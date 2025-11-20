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
                    ->whereIn('source', ['kid_spending', 'goal_payment', 'gift_payment','kid_to_parent']);
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

    // ✅ Calculate total balance
    $receivedMoney = Transaction::where('kid_id', $user->id)
        ->where('type', 'credit')
        ->sum('amount');

    $spentMoney = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->whereIn('source', ['kid_spending', 'goal_saving', 'gift_saving'])
        ->sum('amount');

    $balance = $receivedMoney - $spentMoney; // e.g. ₹11,500

    // ✅ Calculate today's spending (only kid_spending)
    $spentToday = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->where('source', 'kid_spending')
        ->whereDate('created_at', now()->toDateString())
        ->sum('amount');

    // ✅ Calculate remaining daily limit
    $dailyLimit = $user->daily_limit ?? 0;
    $remainingLimit = max($dailyLimit - $spentToday, 0); // e.g. 600 - 0 = 600

    // 🔹 1️⃣ If kid has no balance at all
    if ($balance <= 0) {
        return response()->json([
            'success' => false,
            'message' => 'You have no balance left. Please ask your parent to add money.',
            'remaining_limit' => $remainingLimit,
        ], 400);
    }

    // 🔹 2️⃣ If amount > available balance
    if ($request->amount > $balance) {
        return response()->json([
            'success' => false,
            'message' => 'Insufficient balance. Available ₹' . number_format($balance, 2),
            'remaining_limit' => $remainingLimit,
        ], 400);
    }

    // 🔹 3️⃣ If daily limit reached (spent full limit)
    if ($remainingLimit <= 0) {
        return response()->json([
            'success' => false,
            'message' => 'Daily limit reached. You cannot spend more today.',
            'remaining_limit' => 0,
        ], 400);
    }

    // 🔹 4️⃣ If trying to spend above remaining limit
    if ($request->amount > $remainingLimit) {
        return response()->json([
            'success' => false,
            'message' => 'You can only spend ₹' . number_format($remainingLimit, 2) . ' more today.',
            'remaining_limit' => $remainingLimit,
        ], 400);
    }

    // ✅ If all OK → record transaction
    Transaction::create([
        'parent_id'   => $user->parent_id,
        'kid_id'      => $user->id,
        'amount'      => $request->amount,
        'type'        => 'debit',
        'status'      => 'completed',
        'source'      => 'kid_spending',
        'description' => $request->description,
    ]);

    // ✅ Update remaining limit after transaction
    $spentTodayAfter = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->where('source', 'kid_spending')
        ->whereDate('created_at', now()->toDateString())
        ->sum('amount');

    $remainingLimitAfter = max($dailyLimit - $spentTodayAfter, 0);

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
                        'goal_refund'  // ⭐ ADD THIS
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

    // ⚪ Paid goals — only for silver star highlight
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

    $received = Transaction::where('kid_id', $user->id)->where('type', 'credit')->sum('amount');
    $spent = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->where('source', 'kid_spending')
        ->sum('amount');
    $goalSavings = GoalSaving::where('kid_id', $user->id)->sum('saved_amount');

    $balance = $received - ($spent + $goalSavings);

    if ($request->saved_amount > $balance) {
        return back()->withErrors(['error' => 'Insufficient balance. Available ₹' . number_format($balance, 2)]);
    }

    // ✅ Save record
    GoalSaving::create([
        'goal_id'      => $goal->id,
        'parent_id'    => $user->parent_id,
        'kid_id'       => $user->id,
        'saved_amount' => $request->saved_amount,
        'type'         => 'debit',
        'status'       => 'completed',
    ]);

    $goal->increment('saved_amount', $request->saved_amount);

    // ✅ Auto mark goal completed when reached
    if ($goal->saved_amount >= $goal->target_amount) {
        $goal->status = 1; // Completed
        $goal->save();
    }

    Transaction::create([
        'parent_id'   => $user->parent_id,
        'kid_id'      => $user->id,
        'amount'      => $request->saved_amount,
        'type'        => 'debit',
        'status'      => 'completed',
        'source'      => 'goal_saving',
        'description' => 'Paid for goal: ' . $goal->title,
    ]);

    return back()->with('success', '₹' . $request->saved_amount . ' added to your goal successfully!');
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
    //  PRODUCT IMAGE & PRICE LOGIC
    // ----------------------------

    $title = strtolower($goal->title);
    $productImage = null;
    $basePrice = $goal->target_amount; // user-entered amount (lipstick=1000 etc)

    if (str_contains($title, 'shoe')) {
        $productImage = asset('images/shoe.png');
        $prices = [
            'amazon'   => $basePrice - 101,
            'myntra'   => $basePrice - 90,
            'flipkart' => $basePrice - 50,
        ];
    }
    elseif (str_contains($title, 'football')) {
        $productImage = asset('images/football.png');
        $prices = [
            'amazon'   => $basePrice - 250,
            'myntra'   => $basePrice - 180,
            'flipkart' => $basePrice - 120,
        ];
    }
    elseif (str_contains($title, 'book')) {
        $productImage = asset('images/book.png');
        $prices = [
            'amazon'   => $basePrice - 40,
            'myntra'   => $basePrice - 20,
            'flipkart' => $basePrice - 10,
        ];
    }
        elseif (str_contains($title, 'lipstick')) {
        $productImage = asset('images/lipstick.png');
        $prices = [
            'amazon'   => $basePrice - 400,
            'myntra'   => $basePrice - 200,
            'flipkart' => $basePrice - 350,
        ];
    }
    else {
        // default image
        $productImage = asset('images/products/default.png');
        $prices = [
            'amazon'   => $basePrice - 100,
            'myntra'   => $basePrice - 50,
            'flipkart' => $basePrice - 20,
        ];
    }

    // Find best price
    $bestStore = array_search(min($prices), $prices);

    // Convert to proper format for view
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
     $gift->status = 1;   // ✅ mark as paid
$gift->save();

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

    // Detect the product
    if (str_contains($title, 'shoe')) {
        $productImage = asset('images/gshoe.png');
        $prices = [
            'amazon'   => $basePrice - 100,
            'myntra'   => $basePrice - 80,
            'flipkart' => $basePrice - 60,
        ];
    }
    elseif (str_contains($title, 'bag')) {
        $productImage = asset('images/bag.png');
        $prices = [
            'amazon'   => $basePrice - 150,
            'myntra'   => $basePrice - 120,
            'flipkart' => $basePrice - 90,
        ];
    }
    elseif (str_contains($title, 'football')) {
        $productImage = asset('images/football.png');
        $prices = [
            'amazon'   => $basePrice - 200,
            'myntra'   => $basePrice - 160,
            'flipkart' => $basePrice - 110,
        ];
    }
    elseif (str_contains($title, 'cap')) {
        $productImage = asset('images/cap.png');
        $prices = [
            'amazon'   => $basePrice - 40,
            'myntra'   => $basePrice - 20,
            'flipkart' => $basePrice - 10,
        ];
    }
    else {
        // Default
        $productImage = asset('images/products/default.png');
        $prices = [
            'amazon'   => $basePrice - 80,
            'myntra'   => $basePrice - 50,
            'flipkart' => $basePrice - 30,
        ];
    }

    // Highlight lowest price
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
        'status' => 2,        // Paid
        'saved_amount' => 0,  
        'is_hidden' => 0,     // <-- ⭐ Make visible to parent after paid
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
    ]);

    if (!$user->parent_id) {
        return response()->json([
            'success' => false,
            'message' => 'No parent assigned.',
        ], 400);
    }

    // 🧮 Calculate REAL balance 
    // ❌ DO NOT deduct goal_refund (refund should NOT reduce balance)
    $received = Transaction::where('kid_id', $user->id)
        ->where('type', 'credit')
        ->sum('amount');

    $spent = Transaction::where('kid_id', $user->id)
        ->where('type', 'debit')
        ->whereIn('source', [
            'kid_spending',
            'goal_saving',
            'gift_saving',
            'kid_to_parent' // only normal parent transfer reduces balance
        ])
        ->sum('amount');

    $balance = $received - $spent;

    // ❌ Only normal transfer should check balance
    if (!$request->goal_id && $request->amount > $balance) {
        return response()->json([
            'success' => false,
            'message' => 'Insufficient balance.',
        ], 400);
    }

    // 🧠 Fix description
    $description = "Money returned to parent";

    if ($request->goal_id) {
        $goal = Goal::find($request->goal_id);
        if ($goal) {
            $description = "Returned savings for goal: " . $goal->title;
        }
    }

    // 🎯 Decide proper transaction source
    $source = $request->goal_id
        ? 'goal_refund'      // ⚠ this does NOT reduce balance
        : 'kid_to_parent';   // normal deduction

    // 📝 Create transaction
    Transaction::create([
        'parent_id'   => $user->parent_id,
        'kid_id'      => $user->id,
        'amount'      => $request->amount,
        'type'        => 'debit',
        'status'      => 'completed',
        'source'      => $source,
        'description' => $description,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Money sent to parent successfully!',
        'available_balance' => $request->goal_id
            ? $balance        // refund → balance stays SAME
            : $balance - $request->amount, // normal → reduce
    ]);
}




}