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

    /**
     * 💸 Kid spends money (creates debit)
     */
    public function sendMoney(Request $request)
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');

        $request->validate([
            'amount'      => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        // Check for parent link
        if (!$user->parent_id) {
            return back()->withErrors(['parent' => 'No parent assigned.']);
        }

        // Current balance
        $receivedMoney = Transaction::where('kid_id', $user->id)->where('type', 'credit')->sum('amount');
        $spentMoney = Transaction::where('kid_id', $user->id)->where('type', 'debit')->where('source', 'kid_spending')->sum('amount');
        $balance = $receivedMoney - $spentMoney;

        if ($request->amount > $balance) {
            return back()->withErrors(['amount' => 'Insufficient balance. Available ₹' . number_format($balance, 2)]);
        }

        // ✅ Daily limit check
        if ($user->daily_limit > 0) {
            $spentToday = Transaction::where('kid_id', $user->id)
                ->where('type', 'debit')
                ->where('source', 'kid_spending')
                ->whereDate('created_at', now()->toDateString())
                ->sum('amount');

            if (($spentToday + $request->amount) > $user->daily_limit) {
                $remaining = max($user->daily_limit - $spentToday, 0);
                return back()->withErrors(['amount' => 'Daily limit exceeded. You can still spend ₹' . number_format($remaining, 2)]);
            }
        }

        // ✅ Create debit transaction for kid spending
        Transaction::create([
            'parent_id'   => $user->parent_id,
            'kid_id'      => $user->id,
            'amount'      => $request->amount,
            'type'        => 'debit',
            'status'      => 'completed',
            'source'      => 'kid_spending',
            'description' => $request->description,
        ]);

        return back()->with('success', 'Amount spent successfully!');
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
}
