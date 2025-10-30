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

    // ✅ Load only parent_to_kid debit transactions
    $transactions = Transaction::with('kid')
        ->where('parent_id', $user->id)
        ->where('type', 'debit')
        ->where('source', 'parent_to_kid')
        ->orderBy('created_at', 'desc')
        ->get();

    // ✅ Fetch children of this parent
    $children = User::where('parent_id', $user->id)->get();

    // ✅ Total amount sent to kids
    $totalSent = $transactions->sum('amount');

    // ✅ Fetch all bank accounts linked to the parent
    $bankAccounts = BankAccount::where('user_id', $user->id)->get();

    // ✅ Use selected bank from session or fallback to first
    $selectedBank = session('active_bank_account')
        ? BankAccount::find(session('active_bank_account'))
        : $bankAccounts->first();

    // ✅ Generate wallet ID (4-digit padded user ID)
    $walletId = str_pad($user->id, 4, '0', STR_PAD_LEFT);

    // ✅ Count total kids linked to this parent
    $kidsLinked = $children->count();

    // ✅ Return to parent dashboard view
    return view('parent.parentdashboard', compact(
        'user',
        'transactions',
        'children',
        'totalSent',
        'bankAccounts',
        'selectedBank',
        'walletId',
        'kidsLinked'
    ));
}


    /**
     * 💰 Show "Send Money" page (list of kids)
     */
    public function showSendMoneyPage()
    {
        $user = Auth::user();
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

    /**
     * 👦 Show the "Add Kid" form page
     */
    public function addKid()
    {
        return view('parent.addkid');
    }

    /**
     * 📋 Show Kid Details (list of all kids)
     */
  public function kidDetails()
{
    $user = Auth::user();
    $children = User::where('parent_id', $user->id)->get();

    // ✅ Calculate each kid’s balance
    foreach ($children as $child) {
        $received = \App\Models\Transaction::where('kid_id', $child->id)
            ->where('type', 'credit')
            ->sum('amount');

        $spent = \App\Models\Transaction::where('kid_id', $child->id)
            ->where('type', 'debit')
            ->where('source', 'kid_spending')
            ->sum('amount');

        $child->balance = $received - $spent;
    }

    return view('parent.kiddetails', compact('user', 'children'));
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

    // ✅ 4️⃣ Try sending invitation mail
    try {
        Mail::to($kid->email)->send(new KidInvitationMail($kid));
    } catch (\Exception $e) {
        // Silent fail - continue if email fails
    }

    // ✅ 5️⃣ Redirect to Kid Details page with success message
    return redirect()
        ->route('parent.kiddetails')
        ->with('success', 'Kid added successfully!');
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
            'email'       => 'required|string|email|max:100|unique:users,email,' . $user->id,
            'phone_no'    => 'nullable|string|max:15',
            'dob'         => 'nullable|date',
        ]);

        $user->first_name  = $request->first_name;
        $user->second_name = $request->second_name;
        $user->email       = $request->email;
        $user->phone_no    = $request->phone_no;
        $user->dob         = $request->dob;

        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
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

        $parentId = Auth::id();
        $kid = User::where('id', $request->kid_id)
            ->where('parent_id', $parentId)
            ->firstOrFail();

        // Create debit (parent) and credit (kid) transactions
        Transaction::create([
            'parent_id' => $parentId,
            'kid_id'    => $kid->id,
            'amount'    => $request->amount,
            'type'      => 'debit',
            'status'    => 'completed',
            'source'    => 'parent_to_kid',
        ]);

        Transaction::create([
            'parent_id' => $parentId,
            'kid_id'    => $kid->id,
            'amount'    => $request->amount,
            'type'      => 'credit',
            'status'    => 'completed',
        ]);

        return redirect()
            ->route('parent.sendmoney.page')
            ->with('success', 'Money sent successfully!');
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

    $transactions = Transaction::with('kid')
        ->where('parent_id', $user->id)
        ->where('type', 'debit') // 💳 Parent sends money
        ->where('source', 'parent_to_kid')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('parent.transaction', compact('user', 'transactions'));
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
        return view('parent.addbankaccount', compact('user'));
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




}
