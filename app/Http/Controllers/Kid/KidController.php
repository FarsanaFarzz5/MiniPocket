<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\Models\User;

class KidController extends Controller
{
    /**
     * 🏠 Kid Dashboard — balance and summary
     */
    public function dashboard()
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');

        // ✅ Total received (credits from parent)
        $receivedMoney = Transaction::where('kid_id', $user->id)
            ->where('type', 'credit')
            ->sum('amount');

        // ✅ Total spent (debits by kid)
        $spentMoney = Transaction::where('kid_id', $user->id)
            ->where('type', 'debit')
            ->where('source', 'kid_spending')
            ->sum('amount');

        // ✅ Current balance
        $balance = $receivedMoney - $spentMoney;

        // ✅ Remaining daily limit
        $spentToday = Transaction::where('kid_id', $user->id)
            ->where('type', 'debit')
            ->where('source', 'kid_spending')
            ->whereDate('created_at', now()->toDateString())
            ->sum('amount');

        $remainingLimit = $user->daily_limit > 0
            ? max($user->daily_limit - $spentToday, 0)
            : null;

        // ✅ All related transactions (credits + kid spending)
        $transactions = Transaction::where('kid_id', $user->id)
            ->where(function ($query) {
                $query->where('type', 'credit')
                      ->orWhere(function ($q) {
                          $q->where('type', 'debit')
                            ->where('source', 'kid_spending');
                      });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kid.kiddashboard', compact(
            'user',
            'receivedMoney',
            'spentMoney',
            'balance',
            'remainingLimit',
            'transactions'
        ));
    }

    /**
     * ✏️ Edit profile page
     */
    public function editKid()
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');

        return view('kid.kidedit', compact('user'));
    }

    /**
     * 💾 Update profile
     */
    public function updateKid(Request $request)
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');

        $validator = Validator::make($request->all(), [
            'first_name'  => 'required|string|max:50',
            'phone_no'    => 'nullable|string|max:15',
            'dob'         => 'nullable|date',
            'gender'      => 'nullable|in:male,female,other',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('profile_img')) {
            $user->profile_img = $request->file('profile_img')->store('profile_images', 'public');
        }
        
        /** @var \App\Models\User $user */
        $user->update($request->only('first_name', 'phone_no', 'dob', 'gender'));

        return redirect()->route('kid.dashboard')->with('success', 'Profile updated successfully!');
    }

public function sendMoney(Request $request)
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    $request->validate([
        'amount'      => 'required|numeric|min:1',
        'description' => 'nullable|string|max:255',
    ]);

    if (!$user->parent_id) {
        return response()->json([
            'success' => false,
            'message' => 'No parent assigned.',
            'remaining_limit' => 0
        ], 400);
    }

    // ✅ Calculate balance
    $receivedMoney = Transaction::where('kid_id', $user->id)
        ->where('type', 'credit')
        ->sum('amount');

    $spentMoney = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->where('source', 'kid_spending')
        ->sum('amount');

    $balance = $receivedMoney - $spentMoney;

    if ($request->amount > $balance) {
        return response()->json([
            'success' => false,
            'message' => 'Insufficient balance. Available ₹' . number_format($balance, 2),
            'remaining_limit' => $user->daily_limit - $spentMoney // 👈 include here too
        ], 400);
    }

    // ✅ Daily limit check
    if ($user->daily_limit > 0) {
        $spentToday = Transaction::where('kid_id', $user->id)
            ->where('type', 'debit')
            ->where('source', 'kid_spending')
            ->whereDate('created_at', now()->toDateString())
            ->sum('amount');

        $remainingLimit = max($user->daily_limit - $spentToday, 0);

        // 🚫 Case: exceeds daily limit
        if (($spentToday + $request->amount) > $user->daily_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Daily limit exceeded. You can still spend ₹' . number_format($remainingLimit, 2),
                'remaining_limit' => $remainingLimit // 👈 THIS is what frontend checks
            ], 400);
        }
    }

    // ✅ Create transaction
    Transaction::create([
        'parent_id'   => $user->parent_id,
        'kid_id'      => $user->id,
        'amount'      => $request->amount,
        'type'        => 'debit',
        'status'      => 'completed',
        'source'      => 'kid_spending',
        'description' => $request->description,
    ]);

    // ✅ Calculate updated remaining limit
    $spentTodayAfter = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->where('source', 'kid_spending')
        ->whereDate('created_at', now()->toDateString())
        ->sum('amount');

    $remainingLimitAfter = max($user->daily_limit - $spentTodayAfter, 0);

    return response()->json([
        'success' => true,
        'message' => 'Amount spent successfully!',
        'remaining_limit' => $remainingLimitAfter // 👈 return updated limit even on success
    ]);
}


    public function scanQR()
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    return view('kid.scanqr', compact('user'));
}

public function pay(Request $request)
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    $data = $request->get('data'); // e.g. item=pen&price=30
    parse_str($data, $details);
    $amount = $details['price'] ?? 0;
    $item = $details['item'] ?? 'Purchase';

    if ($amount <= 0) {
        return redirect()->route('kid.dashboard')->withErrors(['invalid' => 'Invalid QR code']);
    }

    // Fetch balance
    $received = Transaction::where('kid_id', $user->id)->where('type', 'credit')->sum('amount');
    $spent = Transaction::where('kid_id', $user->id)->where('type', 'debit')->sum('amount');
    $balance = $received - $spent;

    if ($amount > $balance) {
        return redirect()->route('kid.dashboard')->withErrors(['amount' => 'Insufficient balance']);
    }

    // Record transaction
    Transaction::create([
        'parent_id' => $user->parent_id,
        'kid_id' => $user->id,
        'amount' => $amount,
        'type' => 'debit',
        'status' => 'completed',
        'source' => 'kid_spending',
        'description' => 'Paid for ' . $item,
    ]);

    return redirect()->route('kid.dashboard')->with('success', "₹{$amount} paid for {$item}");
}


public function kidTransactions()
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    // ✅ Fetch credit & debit (kid spending)
    $transactions = Transaction::where('kid_id', $user->id)
        ->where(function ($query) {
            $query->where('type', 'credit')
                  ->orWhere(function ($q) {
                      $q->where('type', 'debit')
                        ->where('source', 'kid_spending');
                  });
        })
        ->orderBy('created_at', 'desc')
        ->get();

    // ✅ Calculate balance
    $receivedMoney = Transaction::where('kid_id', $user->id)
        ->where('type', 'credit')
        ->sum('amount');

    $spentMoney = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->where('source', 'kid_spending')
        ->sum('amount');

    $balance = $receivedMoney - $spentMoney;

    // ✅ Pass $user too (required by sidebar)
    return view('kid.kidtransaction', compact('user', 'transactions', 'balance'));
}

public function moneyTransferPage()
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');
    return view('kid.moneytransfer', compact('user'));
}

}
