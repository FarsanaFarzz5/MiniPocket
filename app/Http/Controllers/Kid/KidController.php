<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Goal;
use App\Models\GoalSaving;
use App\Models\Gift;
use App\Models\GiftSaving;



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
            ->whereIn('source', ['kid_spending', 'goal_saving', 'gift_saving'])
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

        // ✅ All related transactions
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
     * 💸 Spend Money (Send Money)
     */
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
            ->whereIn('source', ['kid_spending', 'goal_saving', 'gift_saving'])
            ->sum('amount');

        $balance = $receivedMoney - $spentMoney;

        if ($request->amount > $balance) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance. Available ₹' . number_format($balance, 2),
                'remaining_limit' => $user->daily_limit - $spentMoney
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

            if (($spentToday + $request->amount) > $user->daily_limit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Daily limit exceeded. You can still spend ₹' . number_format($remainingLimit, 2),
                    'remaining_limit' => $remainingLimit
                ], 400);
            }
        }

        // ✅ Record transaction
        Transaction::create([
            'parent_id'   => $user->parent_id,
            'kid_id'      => $user->id,
            'amount'      => $request->amount,
            'type'        => 'debit',
            'status'      => 'completed',
            'source'      => 'kid_spending',
            'description' => $request->description,
        ]);

        // ✅ Update remaining limit
        $spentTodayAfter = Transaction::where('kid_id', $user->id)
            ->where('type', 'debit')
            ->where('source', 'kid_spending')
            ->whereDate('created_at', now()->toDateString())
            ->sum('amount');

        $remainingLimitAfter = max($user->daily_limit - $spentTodayAfter, 0);

        return response()->json([
            'success' => true,
            'message' => 'Amount spent successfully!',
            'remaining_limit' => $remainingLimitAfter
        ]);
    }

    /**
     * 📷 QR Payment (scan + pay)
     */
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

        $data = $request->get('data');
        parse_str($data, $details);
        $amount = $details['price'] ?? 0;
        $item = $details['item'] ?? 'Purchase';

        if ($amount <= 0) {
            return redirect()->route('kid.dashboard')->withErrors(['invalid' => 'Invalid QR code']);
        }

        $received = Transaction::where('kid_id', $user->id)->where('type', 'credit')->sum('amount');
        $spent = Transaction::where('kid_id', $user->id)->where('type', 'debit')->sum('amount');
        $balance = $received - $spent;

        if ($amount > $balance) {
            return redirect()->route('kid.dashboard')->withErrors(['amount' => 'Insufficient balance']);
        }

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

    /**
     * 📜 Kid Transactions
     */
    public function kidTransactions()
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');

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

        $receivedMoney = Transaction::where('kid_id', $user->id)
            ->where('type', 'credit')
            ->sum('amount');

        $spentMoney = Transaction::where('kid_id', $user->id)
            ->where('type', 'debit')
            ->whereIn('source', ['kid_spending', 'goal_saving', 'gift_saving'])
            ->sum('amount');

        $balance = $receivedMoney - $spentMoney;

        return view('kid.kidtransaction', compact('user', 'transactions', 'balance'));
    }

    public function moneyTransferPage()
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');
        return view('kid.moneytransfer', compact('user'));
    }

    /**
     * 🎯 Goals
     */
    public function kidGoals()
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');

        $goals = Goal::with('savings')->where('kid_id', $user->id)->get();

        return view('kid.goals', compact('goals'));
    }

    public function storeGoal(Request $request)
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');

        $request->validate([
            'title' => 'required|string|max:100',
            'target_amount' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('goal_images', 'public')
            : null;

        Goal::create([
            'kid_id' => $user->id,
            'title' => $request->title,
            'target_amount' => $request->target_amount,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Goal created successfully!');
    }

    public function addSavings(Request $request, Goal $goal)
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');

        $validated = $request->validate([
            'saved_amount' => 'required|numeric|min:1',
        ]);

        $received = Transaction::where('kid_id', $user->id)->where('type', 'credit')->sum('amount');
        $spent = Transaction::where('kid_id', $user->id)->where('type', 'debit')->where('source', 'kid_spending')->sum('amount');
        $goalSavings = GoalSaving::where('kid_id', $user->id)->sum('saved_amount');

        $balance = $received - ($spent + $goalSavings);

        if ($validated['saved_amount'] > $balance) {
            return back()->withErrors(['error' => 'Insufficient balance. Available ₹' . number_format($balance, 2)]);
        }

        if ($goal->saved_amount >= $goal->target_amount) {
            return back()->withErrors(['error' => 'Goal already completed!']);
        }

        GoalSaving::create([
            'goal_id'      => $goal->id,
            'parent_id'    => $user->parent_id,
            'kid_id'       => $user->id,
            'saved_amount' => $validated['saved_amount'],
            'type'         => 'debit',
            'status'       => 'completed',
        ]);

        $goal->increment('saved_amount', $validated['saved_amount']);

        Transaction::create([
            'parent_id'   => $user->parent_id,
            'kid_id'      => $user->id,
            'amount'      => $validated['saved_amount'],
            'type'        => 'debit',
            'status'      => 'completed',
            'source'      => 'goal_saving',
            'description' => 'Added to goal: ' . $goal->title,
        ]);

        return back()->with('success', '₹' . $validated['saved_amount'] . ' added to your goal successfully!');
    }

    public function goalDetails(Goal $goal)
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');

        if ($goal->kid_id !== $user->id) abort(403, 'Unauthorized goal access.');

        $goal->load('savings');
        $progress = $goal->target_amount > 0
            ? round(($goal->saved_amount / $goal->target_amount) * 100, 2)
            : 0;

        return view('kid.goaldetails', compact('goal', 'progress'));
    }

    /**
     * 🎁 GIFT FUNCTIONS
     */
public function showGifts()
{
    $user = Auth::user();  // ✅ change to $user for uniform usage
    if ($user->role != 2) abort(403, 'Unauthorized');

    $gifts = Gift::where('kid_id', $user->id)->get();
    return view('kid.gifts', compact('gifts', 'user')); // ✅ send $user also
}


    public function addGiftPage()
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    return view('kid.addgift', compact('user'));
}

    public function storeGift(Request $request)
    {
        $kid = Auth::user();
        if ($kid->role != 2) abort(403, 'Unauthorized');

        $request->validate([
            'title' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('gifts', 'public')
            : null;

        Gift::create([
            'kid_id' => $kid->id,
            'title' => $request->title,
            'target_amount' => $request->target_amount,
            'saved_amount' => 0,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Gift added successfully!');
    }

    public function addGiftSaving(Request $request)
    {
        $user = Auth::user();
        if ($user->role != 2) abort(403, 'Unauthorized');

        $request->validate([
            'gift_id' => 'required|exists:gifts,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $gift = Gift::find($request->gift_id);

        // ✅ Calculate balance properly
        $received = Transaction::where('kid_id', $user->id)->where('type', 'credit')->sum('amount');
        $spent = Transaction::where('kid_id', $user->id)
            ->where('type', 'debit')
            ->whereIn('source', ['kid_spending', 'goal_saving', 'gift_saving'])
            ->sum('amount');

        $balance = $received - $spent;

        if ($request->amount > $balance) {
            return back()->with('error', 'Insufficient balance. Available ₹' . number_format($balance, 2));
        }

        // ✅ Record in gift_savings
        GiftSaving::create([
            'gift_id'      => $gift->id,
            'kid_id'       => $user->id,
            'parent_id'    => $user->parent_id,
            'saved_amount' => $request->amount,
            'type'         => 'debit',
            'status'       => 'completed',
        ]);

        // ✅ Update gift progress
        $gift->increment('saved_amount', $request->amount);

        // ✅ Record in transactions
        Transaction::create([
            'parent_id'   => $user->parent_id,
            'kid_id'      => $user->id,
            'amount'      => $request->amount,
            'type'        => 'debit',
            'status'      => 'completed',
            'source'      => 'gift_saving',
            'description' => 'Added to gift: ' . $gift->title,
        ]);

        return back()->with('success', '₹' . $request->amount . ' added to your gift successfully!');
    }
}
