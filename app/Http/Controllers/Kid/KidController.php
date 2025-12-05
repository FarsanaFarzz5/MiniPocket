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
    ->whereIn('source', [
        'kid_spending',
        'goal_saving',
        'gift_saving',
        'kid_to_parent' // ➤ ADD HERE
    ])
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
                    ->whereIn('source', [
                        'kid_spending',
                        'goal_payment',
                        'gift_payment',
                        'goal_refund',   // ⭐ Added
                        'gift_refund',   // ⭐ Added
                        'kid_to_parent'
                    ]);
              });
    })
    ->orderBy('created_at', 'desc')
    ->take(2)
    ->get();


        return view('kid.kiddashboard', compact(
            'user',
            'receivedMoney',
            'spentMoney',
            'balance',
            'remainingLimit',
            'transactions',
            
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

    /* -----------------------------------------
        🧮 CALCULATE TOTAL BALANCE
    ----------------------------------------- */
    $receivedMoney = Transaction::where('kid_id', $user->id)
        ->where('type', 'credit')
        ->sum('amount');

    $spentMoney = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->whereIn('source', ['kid_spending', 'goal_saving', 'gift_saving'])
        ->sum('amount');

    $balance = $receivedMoney - $spentMoney;


    /* -----------------------------------------
        📅 TODAY'S SPENDING (kid_spending only)
    ----------------------------------------- */
    $spentToday = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->where('source', 'kid_spending')
        ->whereDate('created_at', now()->toDateString())
        ->sum('amount');

    /* -----------------------------------------
        ⭐ DAILY LIMIT HANDLING
        -1  => UNLIMITED
    ----------------------------------------- */
    if (empty($user->daily_limit) || $user->daily_limit == 0) {
        $dailyLimit = -1;       // unlimited
        $remainingLimit = -1;   // unlimited
    } else {
        $dailyLimit = $user->daily_limit;
        $remainingLimit = max($dailyLimit - $spentToday, 0);
    }


    /* -----------------------------------------
        ❌ 1. NO BALANCE
    ----------------------------------------- */
    if ($balance <= 0) {
        return response()->json([
            'success' => false,
            'message' => 'You have no balance left. Please ask your parent to add money.',
            'remaining_limit' => $remainingLimit,
        ], 400);
    }

    /* -----------------------------------------
        ❌ 2. AMOUNT > BALANCE
    ----------------------------------------- */
    if ($request->amount > $balance) {
        return response()->json([
            'success' => false,
            'message' => 'Insufficient balance. Available ₹' . number_format($balance, 2),
            'remaining_limit' => $remainingLimit,
        ], 400);
    }


    /* -----------------------------------------
        ❌ 3. DAILY LIMIT REACHED (ONLY IF LIMITED)
    ----------------------------------------- */
    if ($dailyLimit != -1 && $remainingLimit <= 0) {
        return response()->json([
            'success' => false,
            'message' => 'Daily limit reached.',
        ], 400);
    }


    /* -----------------------------------------
        ❌ 4. AMOUNT EXCEEDS REMAINING LIMIT (ONLY IF LIMITED)
    ----------------------------------------- */
    if ($dailyLimit != -1 && $request->amount > $remainingLimit) {
        return response()->json([
            'success' => false,
            'message' => 'You can only spend ₹' . number_format($remainingLimit, 2) . ' more today.',
            'remaining_limit' => $remainingLimit,
        ], 400);
    }


    /* -----------------------------------------
        ✅ 5. RECORD THE TRANSACTION
    ----------------------------------------- */
    Transaction::create([
        'parent_id'   => $user->parent_id,
        'kid_id'      => $user->id,
        'amount'      => $request->amount,
        'type'        => 'debit',
        'status'      => 'completed',
        'source'      => 'kid_spending',
        'description' => $request->description,
    ]);


    /* -----------------------------------------
        🔄 UPDATE REMAINING LIMIT AFTER SPEND
    ----------------------------------------- */
    $spentTodayAfter = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->where('source', 'kid_spending')
        ->whereDate('created_at', now()->toDateString())
        ->sum('amount');

    $remainingLimitAfter =
        ($dailyLimit == -1) ? -1 : max($dailyLimit - $spentTodayAfter, 0);


    /* -----------------------------------------
        🟢 SUCCESS RESPONSE
    ----------------------------------------- */
    return response()->json([
        'success' => true,
        'message' => '✅ ₹' . number_format($request->amount, 2) . ' spent successfully!',
        'remaining_limit' => $remainingLimitAfter,
        'available_balance' => $balance - $request->amount,
        'spent_today' => $spentTodayAfter,
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
                    ->whereIn('source', [
                        'kid_spending',
                        'goal_payment',
                        'gift_payment',
                        'kid_to_parent',
                        'goal_refund',
                        'gift_refund' // ⭐ ADD THIS
                    ]);
              });
    })
    ->orderBy('created_at', 'desc')
    ->get();


$receivedMoney = Transaction::where('kid_id', $user->id)
    ->where('type', 'credit')
    ->sum('amount');

// ❌ don't include gift_payment here
$spentMoney = Transaction::where('kid_id', $user->id)
    ->where('type', 'debit')
->whereIn('source', [
    'kid_spending',
    'goal_saving',
    'gift_saving',
    'kid_to_parent'  // ➤ ADD HERE
])

    ->sum('amount');

$balance = $receivedMoney - $spentMoney;


        return view('kid.kidtransaction', compact('user', 'transactions', 'balance'));
    }

public function moneyTransferPage(Request $request)
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    $type = $request->type ?? "normal";  // normal | parent | gift | goal

    return view('kid.moneytransfer', compact('user', 'type'));
}


    /**
     * 🎯 Goals
     */
public function kidGoals()
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    // 🟡 Active goals (On progress or Completed)
$goals = Goal::with('savings')
    ->where('kid_id', $user->id)
    ->whereIn('status', [0, 1])
    ->orderByRaw("FIELD(status, 0, 1)")
    ->get();

$paidGoals = Goal::where('kid_id', $user->id)
    ->where('status', 2)
    ->get();



    return view('kid.goals', compact('goals', 'paidGoals', 'user'));
}


public function storeGoal(Request $request)
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    $request->validate([
        'title' => 'required|string|max:100',
        'target_amount' => 'required|numeric|min:1',
        'is_hidden' => 'nullable|boolean',
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
        'is_hidden' => $request->is_hidden ? 1 : 0,  // ⭐ ADDED
    ]);

    return back()->with('success', 'Goal created successfully!');
}


public function addSavings(Request $request, Goal $goal)
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    $remaining = $goal->target_amount - $goal->saved_amount;

    $request->validate([
        'saved_amount' => 'required|numeric|min:1|max:' . $remaining,
    ]);

    // Correct balance calculation
    $received = Transaction::where('kid_id', $user->id)
        ->where('type', 'credit')
        ->sum('amount');

    $spent = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->whereIn('source', ['kid_spending','goal_saving','gift_saving'])
        ->sum('amount');

    $balance = $received - $spent;

    if ($request->saved_amount > $balance) {
        return back()->withErrors(['error' => 'Insufficient balance. Available ₹' . number_format($balance, 2)]);
    }

    // Save record
    GoalSaving::create([
        'goal_id'      => $goal->id,
        'parent_id'    => $user->parent_id,
        'kid_id'       => $user->id,
        'saved_amount' => $request->saved_amount,
        'type'         => 'debit',
        'status'       => 'completed',
    ]);

    $goal->increment('saved_amount', $request->saved_amount);

    // Mark goal complete
    if ($goal->saved_amount >= $goal->target_amount) {
        $goal->status = 1;
        $goal->save();
    }

    // Add transaction record
    Transaction::create([
        'parent_id'   => $user->parent_id,
        'kid_id'      => $user->id,
        'amount'      => $request->saved_amount,
        'type'        => 'debit',
        'status'      => 'completed',
        'source'      => 'goal_saving',
        'description' => 'Paid for goal: ' . $goal->title,
    ]);

    return back()->with('success', '₹' . $request->saved_amount . ' added successfully!');
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

    // ----------------------------
    // PRODUCT IMAGE & PRICE LOGIC
    // ----------------------------

    $title = strtolower($goal->title);
    $productImage = null;
    $basePrice = $goal->target_amount; // user-entered amount

    // Default price structure based on item type
    if (str_contains($title, 'shoe')) {
        $productImage = asset('images/shoe.png');
        $prices = [
            'amazon'   => $basePrice - 101,
            'myntra'   => $basePrice - 87,
            'flipkart' => $basePrice - 46,
        ];
    }
    elseif (str_contains($title, 'football')) {
        $productImage = asset('images/football.png');
        $prices = [
            'amazon'   => $basePrice - 246,
            'myntra'   => $basePrice - 173,
            'flipkart' => $basePrice - 114,
        ];
    }
    elseif (str_contains($title, 'book')) {
        $productImage = asset('images/book.png');
        $prices = [
            'amazon'   => $basePrice - 38,
            'myntra'   => $basePrice - 20,
            'flipkart' => $basePrice - 10,
        ];
    }
    elseif (str_contains($title, 'lipstick')) {
        $productImage = asset('images/lipstick.png');
        $prices = [
            'amazon'   => $basePrice - 383,
            'myntra'   => $basePrice - 184,
            'flipkart' => $basePrice - 342,
        ];
    }
    else {
        $productImage = asset('images/products/default.png');
        $prices = [
            'amazon'   => $basePrice - 82,
            'myntra'   => $basePrice - 50,
            'flipkart' => $basePrice - 20,
        ];
    }

    // ⭐ NEW SMOOTH PRICING RULE FOR AMOUNTS UP TO ₹200
    if ($basePrice <= 200) {
        $prices = [
            'amazon'   => $basePrice - 30,  // small discount
            'myntra'   => $basePrice - 20,
            'flipkart' => $basePrice - 10,
        ];
    }

    // ⭐ FIX: Prevent negative prices
    foreach ($prices as $key => $value) {
        $prices[$key] = max($value, 1);
    }

    // Identify best store
    $bestStore = array_search(min($prices), $prices);

    // Data to view
    $bestPrices = [
        [
            'store'   => 'Amazon.in',
            'logo'    => $productImage,
            'price'   => $prices['amazon'],
            'stock'   => 'In stock online',
            'delivery'=> 'Delivery ₹40',
            'note'    => $bestStore == 'amazon' ? 'Best price' : null
        ],
        [
            'store'   => 'Myntra',
            'logo'    => $productImage,
            'price'   => $prices['myntra'],
            'stock'   => 'In stock online',
            'delivery'=> 'Free delivery',
            'note'    => $bestStore == 'myntra' ? 'Best price' : null
        ],
        [
            'store'   => 'Flipkart',
            'logo'    => $productImage,
            'price'   => $prices['flipkart'],
            'stock'   => 'In stock online',
            'delivery'=> 'Delivery ₹60',
            'note'    => $bestStore == 'flipkart' ? 'Best price' : null
        ],
    ];

    return view('kid.goaldetails', compact('goal', 'progress', 'bestPrices'));
}


    /**
     * 🎁 GIFT FUNCTIONS
     */
public function showGifts()
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    $gifts = Gift::where('kid_id', $user->id)->get();

    // 🔥 Attach Best Prices to every gift
    foreach ($gifts as $gift) {
        $gift->bestPrices = $this->generateBestPricesForGift($gift);
    }

    return view('kid.gifts', compact('gifts', 'user'));
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

    // ✅ Redirect to Gifts page after saving
    return redirect()->route('kid.gifts')->with('success', 'Gift added successfully!');
}

public function addGiftSaving(Request $request)
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    $gift = Gift::findOrFail($request->gift_id);

    // ✅ Remaining amount allowed to save for this gift
    $remaining = $gift->target_amount - $gift->saved_amount;

    // ✅ Validate input + prevent exceeding target
    $request->validate([
        'gift_id' => 'required|exists:gifts,id',
        'amount'  => 'required|numeric|min:1|max:' . $remaining,
    ]);

    // ✅ Calculate kid balance properly
    $received = Transaction::where('kid_id', $user->id)
        ->where('type', 'credit')
        ->sum('amount');

    // ✅ Deduct only gift_saving, goal_saving, kid_spending (NOT gift_payment)
    $spent = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->whereIn('source', ['kid_spending', 'goal_saving', 'gift_saving'])
        ->sum('amount');

    $balance = $received - $spent;

    // ❌ Prevent saving if kid doesn’t have enough balance
    if ($request->amount > $balance) {
        return back()->withErrors(['error' => 'Insufficient balance. Available ₹' . number_format($balance, 2)]);
    }

    // ✅ Save to gift_savings table
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

    // ✅ Record in transactions (this reduces balance only once)
    Transaction::create([
        'parent_id'   => $user->parent_id,
        'kid_id'      => $user->id,
        'amount'      => $request->amount,
        'type'        => 'debit',
        'status'      => 'completed',
        'source'      => 'gift_saving',  // ✅ important
        'description' => 'Saving for gift: ' . $gift->title,
    ]);

    return back()->with('success', '₹' . $request->amount . ' added to your gift successfully!');
}

public function sendGiftMoney(Request $request)
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    $request->validate([
        'amount' => 'required|numeric|min:1',
        'description' => 'nullable|string|max:255',
    ]);

    // ✅ Record gift payment (NO BALANCE DEDUCTION - already deducted earlier)
    Transaction::create([
        'parent_id'   => $user->parent_id,
        'kid_id'      => $user->id,
        'amount'      => $request->amount,
        'type'        => 'debit',
        'status'      => 'completed',
        'source'      => 'gift_payment',
        'description' => 'Paid for gift: ' . ($request->description ?? 'Gift'),
    ]);

    // ✅ Reset saved amount & remove gift from list
    $gift = Gift::where('kid_id', $user->id)
                ->where('title', $request->description)
                ->first();

    if ($gift) {
        // Reset saved amount and target (so it becomes 0 and disappears from summary)
$gift->update([
    'status'        => 1,
    'saved_amount'  => 0,
    'target_amount' => 0,  // 🔥 MUST RESET
]);

        // ✅ This hides the gift card from UI
        session(['paid_gift_id' => $gift->id]);
    }

    return response()->json([
        'success' => true,
        'message' => '🎁 Gift payment recorded successfully!',
    ]);
}

private function generateBestPricesForGift($gift)
{
    $title = strtolower($gift->title);
    $basePrice = $gift->target_amount;

    // ----------------------------
    // PRODUCT IMAGE & PRICE LOGIC
    // ----------------------------

    if (str_contains($title, 'shoe')) {
        $productImage = asset('images/gshoe.png');
        $prices = [
            'amazon'   => $basePrice - 91,
            'myntra'   => $basePrice - 74,
            'flipkart' => $basePrice - 60,
        ];
    }
    elseif (str_contains($title, 'bag')) {
        $productImage = asset('images/bag.png');
        $prices = [
            'amazon'   => $basePrice - 148,
            'myntra'   => $basePrice - 118,
            'flipkart' => $basePrice - 87,
        ];
    }
    elseif (str_contains($title, 'football')) {
        $productImage = asset('images/football.png');
        $prices = [
            'amazon'   => $basePrice - 192,
            'myntra'   => $basePrice - 164,
            'flipkart' => $basePrice - 107,
        ];
    }
    elseif (str_contains($title, 'cap')) {
        $productImage = asset('images/cap.png');
        $prices = [
            'amazon'   => $basePrice - 37,
            'myntra'   => $basePrice - 24,
            'flipkart' => $basePrice - 10,
        ];
    }
    else {
        $productImage = asset('images/products/default.png');
        $prices = [
            'amazon'   => $basePrice - 42,
            'myntra'   => $basePrice - 73,
            'flipkart' => $basePrice - 12,
        ];
    }

    // ⭐ NEW SMOOTH PRICING RULE FOR AMOUNTS UP TO ₹200
    if ($basePrice <= 200) {
        $prices = [
            'amazon'   => $basePrice - 30,
            'myntra'   => $basePrice - 20,
            'flipkart' => $basePrice - 10,
        ];
    }

    // ⭐ FIX: Prevent negative or zero prices
    foreach ($prices as $key => $value) {
        $prices[$key] = max($value, 1);
    }

    // Identify best store
    $bestStore = array_search(min($prices), $prices);

    return [
        [
            'store'   => 'Amazon.in',
            'logo'    => $productImage,
            'price'   => $prices['amazon'],
            'stock'   => 'In stock online',
            'delivery'=> 'Delivery ₹40',
            'note'    => $bestStore == 'amazon' ? 'Best price' : null
        ],
        [
            'store'   => 'Myntra',
            'logo'    => $productImage,
            'price'   => $prices['myntra'],
            'stock'   => 'In stock online',
            'delivery'=> 'Free delivery',
            'note'    => $bestStore == 'myntra' ? 'Best price' : null
        ],
        [
            'store'   => 'Flipkart',
            'logo'    => $productImage,
            'price'   => $prices['flipkart'],
            'stock'   => 'In stock online',
            'delivery'=> 'Delivery ₹60',
            'note'    => $bestStore == 'flipkart' ? 'Best price' : null
        ],
    ];
}


/**
 * ✅ GOAL PAYMENT (similar to gift payment)
 */
public function sendGoalPayment(Request $request)
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    $request->validate([
        'amount' => 'required|numeric|min:1',
        'description' => 'nullable|string|max:255',
        'goal_id' => 'required|exists:goals,id',
    ]);

    $goal = Goal::findOrFail($request->goal_id);

    // Transaction record
    Transaction::create([
        'parent_id'   => $user->parent_id,
        'kid_id'      => $user->id,
        'amount'      => $request->amount,
        'type'        => 'debit',
        'status'      => 'completed',
        'source'      => 'goal_payment',
        'description' => 'Paid for goal: ' . ($request->description ?? $goal->title),
    ]);

    // ⭐ Mark as paid + unhide
 $goal->update([
    'status' => 2,         // paid
    'saved_amount' => 0,
    'target_amount' => 0,  // 🔥 reset target
    'is_hidden' => 0
]);


    return response()->json([
        'success' => true,
        'message' => '🎯 Goal marked as paid successfully!',
    ]);
}

public function kidSendToParent(Request $request)
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    $request->validate([
        'amount'      => 'required|numeric|min:1',
        'description' => 'nullable|string|max:255',
        'goal_id'     => 'nullable|integer',
        'gift_id'     => 'nullable|integer',
    ]);

    if (!$user->parent_id) {
        return response()->json([
            'success' => false,
            'message' => 'No parent assigned.',
        ], 400);
    }

    /* ----------------------------------------------------------
        🧮 Calculate REAL balance 
        Gift refund / goal refund must NOT reduce balance
    ---------------------------------------------------------- */
    $received = Transaction::where('kid_id', $user->id)
        ->where('type', 'credit')
        ->sum('amount');

    $spent = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->whereIn('source', [
            'kid_spending',
            'goal_saving',
            'gift_saving',
            'kid_to_parent'
        ])
        ->sum('amount');

    $balance = $received - $spent;

    // ❌ Only normal parent transfer should check available balance
    if (!$request->goal_id && !$request->gift_id && $request->amount > $balance) {
        return response()->json([
            'success' => false,
            'message' => 'Insufficient balance.',
        ], 400);
    }


    /* ----------------------------------------------------------
        📝 Determine transaction source + description
    ---------------------------------------------------------- */
    $source = 'kid_to_parent';  // default
    $description = "Money returned to parent";



// ⭐ GOAL REFUND
if ($request->goal_id) {

    $goal = Goal::find($request->goal_id);

    if ($goal) {

        $source = 'goal_refund';
        $description = "Returned savings for goal: " . $goal->title;

        // ⭐ Corrected: goal refund = Paid (status 2)
    $goal->update([
    'saved_amount'  => 0,
    'target_amount' => 0,
    'status'        => 2, // paid
    'is_locked'     => 1,
    'is_hidden'     => 0,  // ⭐ UNHIDE FOR PARENT
]);
    }
}



    // ⭐ GIFT REFUND
    if ($request->gift_id) {

        $gift = Gift::find($request->gift_id);

        if ($gift) {

            $source = 'gift_refund';
            $description = "Returned savings for gift: " . $gift->title;

            // Hide gift after refund
            $gift->update([
    'status'        => 1,
    'saved_amount'  => 0,
    'target_amount' => 0,   // 🔥 MUST RESET
]);

        }
    }


    /* ----------------------------------------------------------
        📝 Create the Transaction
    ---------------------------------------------------------- */
    Transaction::create([
        'parent_id'   => $user->parent_id,
        'kid_id'      => $user->id,
        'amount'      => $request->amount,
        'type'        => 'debit',
        'status'      => 'completed',
        'source'      => $source,
        'description' => $description,
    ]);


    /* ----------------------------------------------------------
        🟢 Return JSON response
    ---------------------------------------------------------- */
    return response()->json([
        'success' => true,
        'message' => 'Money sent to parent successfully!',
        'available_balance' => ($request->goal_id || $request->gift_id)
            ? $balance        // refunds keep balance SAME
            : $balance - $request->amount, // normal transfer reduces
    ]);
}

public function achievements()
{
    $user = Auth::user();
    if ($user->role != 2) abort(403, 'Unauthorized');

    /* --------------------------------------------------
     * 1️⃣  FETCH REFUNDS FIRST  
     * --------------------------------------------------
     */
    $refunds = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->whereIn('source', ['goal_refund', 'gift_refund'])
        ->get()
        ->map(function($r){
            $r->type = 'refund';
            $r->date = $r->created_at;
            return $r;
        });

    // Collect refunded goal IDs & gift IDs to EXCLUDE from Paid list
    $refundedGoalIDs = $refunds
        ->filter(fn($x) => $x->source == 'goal_refund')
        ->map(function($r){
            // extract goal title from description
            // 'Returned savings for goal: Book'
            $title = trim(str_replace("Returned savings for goal:", "", $r->description));
            $goal = Goal::where('kid_id', $r->kid_id)->where('title', $title)->first();
            return $goal?->id;
        })
        ->filter()
        ->toArray();

    $refundedGiftTitles = $refunds
        ->filter(fn($x) => $x->source == 'gift_refund')
        ->map(function($r){
            return trim(str_replace("Returned savings for gift:", "", $r->description));
        })
        ->toArray();


    /* --------------------------------------------------
     * 2️⃣  PAID GOALS → EXCLUDE refunded ones
     * --------------------------------------------------
     */
    $paidGoals = Goal::where('kid_id', $user->id)
        ->where('status', 2)
        ->whereNotIn('id', $refundedGoalIDs)   // ⭐ FIX
        ->get()
        ->map(function($g){
            $g->type = 'goal';
            $g->date = $g->updated_at;
            return $g;
        });


    /* --------------------------------------------------
     * 3️⃣  PAID GIFTS → EXCLUDE refunded ones
     * --------------------------------------------------
     */
    $paidGifts = Gift::where('kid_id', $user->id)
        ->where('target_amount', 0)
        ->where('saved_amount', 0)
        ->whereNotIn('title', $refundedGiftTitles)  // ⭐ FIX
        ->get()
        ->map(function($g){
            $g->type = 'gift';
            $g->date = $g->updated_at;
            return $g;
        });


    /* --------------------------------------------------
     * 4️⃣  MERGE EVERYTHING PROPERLY
     * --------------------------------------------------
     */
    $allAchievements = collect()
        ->merge($paidGoals)
        ->merge($paidGifts)
        ->merge($refunds)
        ->sortByDesc('date')
        ->values();

    return view('kid.achievements', compact('user', 'allAchievements'));
}

}