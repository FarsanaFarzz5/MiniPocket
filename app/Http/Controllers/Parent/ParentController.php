<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\KidInvitationMail;

class ParentController extends Controller
{
    /**
     * 🏠 Display the Parent Dashboard (parent info + transactions summary)
     */
 // 🏠 Dashboard
public function dashboard()
{
    $user = Auth::user();

    // Get all kids of this parent
    $children = User::where('parent_id', $user->id)->get();
    $kidIds = $children->pluck('id');

    // ⭐ COMBINED TRANSACTIONS (Parent to kid + Kid activity + Kid sends to parent)
   // ⭐ ONLY Parent → Kid sent transactions (debit)
$transactions = Transaction::with('kid')
    ->where('parent_id', $user->id)
    ->where('source', 'parent_to_kid')
    ->where('type', 'debit')
    ->orderBy('created_at', 'desc')
    ->get();


    // Total amount parent sent to all kids
    $totalSent = Transaction::where('parent_id', $user->id)
        ->where('source', 'parent_to_kid')
        ->sum('amount');

    // Total amount parent received from kids
    $totalReceivedFromKids = Transaction::where('parent_id', $user->id)
        ->where('source', 'kid_to_parent')
        ->sum('amount');

    // Bank accounts
    $bankAccounts = BankAccount::where('user_id', $user->id)->get();

    // Selected bank
    $selectedBank = session('active_bank_account')
        ? BankAccount::find(session('active_bank_account'))
        : $bankAccounts->first();

    // Wallet ID
    $walletId = str_pad($user->id, 4, '0', STR_PAD_LEFT);

    // Total kids linked
    $kidsLinked = $children->count();

    // Kids goals
    $kidsGoals = \App\Models\Goal::with('kid')
        ->whereIn('kid_id', $kidIds)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('parent.parentdashboard', compact(
        'user',
        'transactions',
        'children',
        'totalSent',
        'totalReceivedFromKids',
        'bankAccounts',
        'selectedBank',
        'walletId',
        'kidsLinked',
        'kidsGoals'
    ));
}


    /**
     * 💰 Show "Send Money" page (list of kids)
     */
public function showSendMoneyPage()
{
    $user = Auth::user();

    // 🛑 No bank? Redirect
    if (BankAccount::where('user_id', $user->id)->count() == 0) {
        return redirect()->route('parent.addbankaccount')
            ->with('error', 'Please add a bank account before sending money.');
    }

    $children = User::where('parent_id', $user->id)->get();

    return view('parent.sendmoney', compact('user', 'children'));
}


    /**
     * 💵 Show individual kid payment page
     */
    public function showKidPaymentPage($kidId)
    {
        $user = Auth::user();

        // Ensure kid belongs to logged-in parent
        $kid = User::where('id', $kidId)
            ->where('parent_id', $user->id)
            ->firstOrFail();

        return view('parent.paykid', compact('user', 'kid'));
    }

    
public function kidManagement()
{
    $user = Auth::user();

    // Fetch all kids
    $children = User::where('parent_id', $user->id)->get();

    $allEmails = User::pluck('email')->toArray();

    foreach ($children as $child) {

        // ⭐ 1. Money parent sent to kid (credit)
        $parentToKid = Transaction::where('kid_id', $child->id)
            ->where('source', 'parent_to_kid')
            ->sum('amount');

        // ⭐ 2. Kid goal savings + gift savings + money received
        $kidCredits = Transaction::where('kid_id', $child->id)
            ->where('type', 'credit')
            ->whereIn('source', [
                'goal_saving',
                'gift_saving',
                'kid_to_parent', // credit in kid panel? No → remove if unwanted
                
            ])
            ->sum('amount');

        // ⭐ Total credits
        $totalCredits = $parentToKid + $kidCredits;

        // ⭐ 3. Kid spends, goal payments, sending to parent
        $kidDebits = Transaction::where('kid_id', $child->id)
            ->where('type', 'debit')
            ->whereIn('source', [
                'kid_spending',
                'goal_payment',
                'gift_payment',
                'kid_to_parent',
                'goal_refund',
                'gift_refund'
            ])
            ->sum('amount');

        // ⭐ Calculate final balance
        $child->balance = $totalCredits - $kidDebits;
    }

    return view('parent.kid', compact('user', 'children', 'allEmails'));
}


  /**
 * ➕ Store a new Kid account
 */
public function storeKid(Request $request)
{
    // ✅ Validate input
    $validator = Validator::make($request->all(), [
        'first_name'     => 'required|string|max:50',
        'email'          => 'required|string|email|max:100|unique:users,email',
        'phone_no'       => 'nullable|string|max:15',
        'dob'            => 'nullable|date',
        'gender'         => 'nullable|in:male,female,other',
        'avatar_choice'  => 'nullable|string|max:255',
        'profile_img'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $inviteToken = Str::random(32);
    $temporaryPassword = '123456789';
    $imagePath = null;

    // ✅ 1️⃣ If parent uploads a profile image manually
    if ($request->hasFile('profile_img')) {
        $imagePath = $request->file('profile_img')->store('profile_images', 'public');
    }

    // ✅ 2️⃣ If parent selects one of the default avatars
    elseif ($request->filled('avatar_choice')) {
        $avatarFile = $request->avatar_choice;

        // 👇 Correct path for your system (C:\xampp\htdocs\minipocket\public\images)
        $sourcePath = public_path('images/' . $avatarFile);
        $destinationDir = storage_path('app/public/profile_images/');

        if (file_exists($sourcePath)) {
            if (!file_exists($destinationDir)) {
                mkdir($destinationDir, 0777, true);
            }

            // ✅ Create a unique filename to avoid overwriting
            $extension = pathinfo($avatarFile, PATHINFO_EXTENSION);
            $filename = pathinfo($avatarFile, PATHINFO_FILENAME);
            $uniqueFile = $filename . '_' . uniqid() . '.' . $extension;

            // ✅ Copy the selected avatar into the storage folder
            copy($sourcePath, $destinationDir . $uniqueFile);

            // ✅ Save relative path (used for displaying later)
            $imagePath = 'profile_images/' . $uniqueFile;
        }
    }

    // ✅ 3️⃣ Create the kid user
    $kid = User::create([
        'first_name'   => $request->first_name,
        'second_name'  => $request->second_name ?? null,
        'email'        => $request->email,
        'phone_no'     => $request->phone_no,
        'role'         => 2, // Kid role
        'parent_id'    => Auth::id(),
        'invite_token' => $inviteToken,
        'dob'          => $request->dob,
        'gender'       => $request->gender,
        'profile_img'  => $imagePath,
        'password'     => Hash::make($temporaryPassword),
    ]);

// After sending email
try {
    Mail::to($kid->email)->send(new KidInvitationMail($kid));
} catch (\Exception $e) {
    // Silent fail
}

// Add kid email to session for popup
session()->flash('kid_email', $kid->email);

// Redirect
return redirect()
    ->route('parent.kid.management')
    ->with('kid_added', true);


}

    /**
     * 🔁 Re-send invitation email to kid
     */
    public function resendInvite(Request $request, $id)
    {
        $kid = User::where('id', $id)
            ->where('parent_id', Auth::id())
            ->firstOrFail();

        if (!$kid->invite_token) {
            $kid->invite_token = Str::random(32);
            $kid->save();
        }

        try {
            Mail::to($kid->email)->send(new KidInvitationMail($kid));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send invitation email.');
        }

        return back()->with('success', 'Invitation email sent successfully!');
    }

    
        /**
     * 🧍‍♂️ Update Parent Profile (without profile image)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

            $request->validate([
                'first_name'  => 'required|string|max:50',
                'second_name' => 'nullable|string|max:50',

                // ✅ Email must be unique except current user
                'email'       => 'required|string|email|max:100|unique:users,email,' . $user->id,

                // ✅ Phone also unique except current user
                'phone_no'    => 'nullable|string|max:15|unique:users,phone_no,' . $user->id,

                'dob'         => 'nullable|date',
            ]);


        $user->first_name  = $request->first_name;
        $user->second_name = $request->second_name;
        $user->email       = $request->email;
        $user->phone_no    = $request->phone_no;
        $user->dob         = $request->dob;

        // dd($user);

        /** @var \App\Models\User $user */
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');

    }

    /**
     * ✏️ Show Edit Profile Page
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('parent.editprofile', compact('user'));
    }

    /**
     * 💸 Send money to a Kid
     */
   public function sendMoney(Request $request)
{
    $request->validate([
        'kid_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:1',
    ]);

    $user = Auth::user();

    // 🛑 BLOCK sending money if parent has NO bank account
    if (BankAccount::where('user_id', $user->id)->count() == 0) {
        return response()->json([
            'success' => false,
            'message' => 'Please add a bank account first.'
        ], 403);
    }

    $parentId = $user->id;

    // Ensure kid belongs to this parent
    $kid = User::where('id', $request->kid_id)
        ->where('parent_id', $parentId)
        ->firstOrFail();

    // 💳 Create debit transaction (parent → kid)
    Transaction::create([
        'parent_id' => $parentId,
        'kid_id'    => $kid->id,
        'amount'    => $request->amount,
        'type'      => 'debit',
        'status'    => 'completed',
        'source'    => 'parent_to_kid',
    ]);

    // 💰 Create credit transaction (kid receives)
    Transaction::create([
        'parent_id' => $parentId,
        'kid_id'    => $kid->id,
        'amount'    => $request->amount,
        'type'      => 'credit',
        'status'    => 'completed',
        'source'    => 'parent_to_kid',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Money sent successfully.'
    ]);
}


    /**
     * 💰 Set daily limit for a kid
     */
    public function setKidLimit(Request $request, $kidId)
    {
        $request->validate([
            'daily_limit' => 'required|numeric|min:0',
        ]);

        $kid = User::where('id', $kidId)
            ->where('parent_id', Auth::id())
            ->firstOrFail();

        $kid->daily_limit = $request->daily_limit;
        $kid->save();

        return back()->with('success', 'Daily limit set successfully for ' . $kid->first_name);
    }

    /**
 * 📜 Parent Transaction History (Debit Only)
 */
public function transactionHistory()
{
    $user = Auth::user();

    // All kids of this parent
    $kidIds = User::where('parent_id', $user->id)->pluck('id');

    // 1️⃣ Parent → Kid Transfers
 $parentTransactions = Transaction::with('kid')
    ->where('parent_id', $user->id)
    ->whereIn('kid_id', $kidIds)
    ->where('source', 'parent_to_kid')
    ->where('type', 'debit')   // SHOW ONLY PARENT'S DEBITS
    ->orderBy('created_at', 'desc')
    ->get();


    // 2️⃣ Kid Spending + Goal Payment + Gift Payment
$kidTransactions = Transaction::with('kid')
    ->whereIn('kid_id', $kidIds)
    ->whereIn('source', [
        'kid_spending',
        'goal_payment',
        'gift_payment',
        'kid_to_parent',
        'goal_refund',
        'gift_refund'  // ⭐ FIXED
    ])


    ->orderBy('created_at', 'desc')
    ->get();


    return view('parent.transaction', compact(
        'parentTransactions',
        'kidTransactions'
    ));
}


    /**
     * 🏦 View All Bank Accounts
     */
    public function bankAccounts()
    {
        $user = Auth::user();
        $accounts = BankAccount::where('user_id', $user->id)->get();

        return view('parent.bankaccounts', compact('user', 'accounts'));
    }

    /**
     * ➕ Show Add Bank Account Page
     */
 public function addBankAccount()
{
    $user = Auth::user();

    // Default values (to avoid undefined variable errors)
    $bankName = 'Select Bank';
    $bankFile = 'defaultbank.png'; // make sure this exists in /public/images
    $cardColor = '#1976d2';

    return view('parent.addbankaccount', compact('user', 'bankName', 'bankFile', 'cardColor'));
}


    public function addSpecificBank($bank)
{
    $bankName = ucwords(strtolower($bank));

    // Map logo + color
    $bankMap = [
        'canara bank' => ['file' => 'canara.png', 'color' => '#2b8ccd'],
        'axis bank'   => ['file' => 'axis.png',   'color' => '#a1005f'],
        'hdfc bank'   => ['file' => 'hdfc.png',   'color' => '#004ba0'],
        'icici bank'  => ['file' => 'icici.png',  'color' => '#e65100'],
        'sbi bank'    => ['file' => 'sbi.png',    'color' => '#1a73e8'],
        'kotak bank'=> ['file' => 'kotak.png',   'color' => '#1976d2'],
    ];

    $key = strtolower(trim($bankName));
    $bankFile = $bankMap[$key]['file'] ?? 'kotak.png';
    $cardColor = $bankMap[$key]['color'] ?? '#1976d2';

    return view('parent.addbankaccount', compact('bankName', 'bankFile', 'cardColor'));
}

    /**
     * 💾 Store a New Bank Account
     */
/**
 * 💳 Store a New Bank Card (card_number, expiry_date, cvv)
 */
public function storeBankAccount(Request $request)
{
    $request->validate([
        'bank_name'   => 'required|string|max:255',
        'card_number' => 'required|string|max:30',
        'expiry_date' => 'required|string|max:10',
        'cvv'         => 'required|string|max:10',
    ]);

    BankAccount::create([
        'user_id'     => Auth::id(),
        'bank_name'   => $request->bank_name,
        'card_number' => $request->card_number,
        'expiry_date' => $request->expiry_date,
        'cvv'         => $request->cvv,
        'branch_name' => $request->branch_name,
    ]);

    return redirect()->route('parent.bankaccounts')
        ->with('success', 'Card added successfully!');
}


    /**
     * ✅ Select Bank Account as Primary
     */
    public function selectBank($id)
    {
        $user = Auth::user();

        // Unselect all accounts
        BankAccount::where('user_id', $user->id)->update(['is_selected' => false]);

        // Select chosen one
        $selected = BankAccount::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($selected) {
            $selected->update(['is_selected' => true]);
            session(['active_bank_account' => $selected->id]);
        }

        return redirect()->route('parent.bankaccounts')->with('success', 'Primary bank account updated.');
    }

    public function clearBankSession()
{
    session()->forget('active_bank_account');
    return response()->json(['message' => 'Bank session cleared']);
}


public function setPrimaryBank($bankId)
{
    $user = Auth::user();
    $parentId = $user->id;

    \App\Models\BankAccount::where('user_id', $parentId)
        ->update(['is_primary' => false]);

    \App\Models\BankAccount::where('id', $bankId)
        ->where('user_id', $parentId)
        ->update(['is_primary' => true]);

    return response()->json(['success' => true]);
}

public function unsetPrimaryBank($bankId)
{
    $user = Auth::user();
    $parentId = $user->id;

    \App\Models\BankAccount::where('id', $bankId)
        ->where('user_id', $parentId)
        ->update(['is_primary' => false]);

    return response()->json(['success' => true]);
}

public function editKid($id)
{
    $kid = User::where('id', $id)
        ->where('parent_id', Auth::id())
        ->firstOrFail();

    return view('parent.editkid', compact('kid'));
}

public function updateKid(Request $request, $id)
{
    $kid = User::where('id', $id)
        ->where('parent_id', Auth::id())
        ->firstOrFail();

    $request->validate([
        'first_name' => 'required|string|max:50',
        'email' => 'required|email|max:100|unique:users,email,' . $id,
        'dob' => 'nullable|date',
        'gender' => 'nullable|string'
    ]);

    $kid->update([
        'first_name' => $request->first_name,
        'email' => $request->email,
        'dob' => $request->dob,
        'gender' => $request->gender
    ]);

    return redirect()
        ->route('parent.kid.management')
        ->with('success', 'Kid updated successfully!');
}


public function deleteKid($kidId)
{
    $parent = Auth::user();

    $kid = User::where('id', $kidId)
        ->where('parent_id', $parent->id)
        ->firstOrFail();

    $kid->delete();

    return response()->json([
        'success' => true,
        'message' => 'Kid deleted successfully.',
        'kidId' => $kidId
    ]);
}

}
