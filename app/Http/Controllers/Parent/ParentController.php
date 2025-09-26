<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\KidInvitationMail;

class ParentController extends Controller
{
    /**
     * Display the parent dashboard with all their children and transactions.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Fetch transactions where parent sends money (debit)
$transactions = Transaction::where('parent_id', $user->id)
    ->orderBy('created_at', 'desc')
    ->get();
        // Fetch all children of this parent
        $children = User::where('parent_id', $user->id)->get();

        return view('dashboard.parent', compact('user', 'transactions', 'children'));
    }

    /**
     * Store a new kid account (without sending email here).
     */
    public function storeKid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'  => 'required|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'email'       => 'required|string|email|max:100|unique:users,email',
            'phone_no'    => 'nullable|string|max:15',
            'password'    => 'required|string|min:6|confirmed',
            'dob'         => 'nullable|date',
            'gender'      => 'nullable|in:male,female,other',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle profile image upload
        $profileImagePath = null;
        if ($request->hasFile('profile_img')) {
            $profileImagePath = $request->file('profile_img')->store('profile_images', 'public');
        }

        // Generate a unique invitation token
        $inviteToken = Str::random(32);

        // Create the kid user
        User::create([
            'first_name'   => $request->first_name,
            'second_name'  => $request->second_name,
            'email'        => $request->email,
            'phone_no'     => $request->phone_no,
            'password'     => Hash::make($request->password),
            'role'         => 2, // kid role
            'parent_id'    => Auth::id(),
            'invite_token' => $inviteToken,
            'dob'          => $request->dob,
            'gender'       => $request->gender,
            'profile_img'  => $profileImagePath,
        ]);

        return back()->with('success', 'Kid added successfully. Click Invite to send an email.');
    }

    /**
     * Send or resend the invitation email to an existing kid.
     */
    public function resendInvite(Request $request, $id)
    {
        $email = $request->input('email');

        $kid = User::where('id', $id)
            ->where('parent_id', Auth::id())
            ->firstOrFail();

        // Ensure kid has an invite token
        if (!$kid->invite_token) {
            $kid->invite_token = Str::random(32);
            $kid->save();
        }

        if ($email && $email !== $kid->email) {
            return back()->withErrors(['email' => 'Email does not match the kid\'s registered email.']);
        }

        // Send the invitation email
        Mail::to($kid->email)->send(new KidInvitationMail($kid));

        return back()->with('success', 'Invitation sent successfully!');
    }

    /**
     * Add or update parent profile.
     */
    public function addProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'first_name'  => 'required|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'email'       => 'required|string|email|max:100|unique:users,email,' . $user->id,
            'phone_no'    => 'nullable|string|max:15',
            'dob'         => 'nullable|date',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->first_name  = $request->first_name;
        $user->second_name = $request->second_name;
        $user->email       = $request->email;
        $user->phone_no    = $request->phone_no;
        $user->dob         = $request->dob;

        if ($request->hasFile('profile_img')) {
            $user->profile_img = $request->file('profile_img')->store('profile_images', 'public');
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Send money from parent to kid (creates a debit transaction for parent).
     */
/**
 * Send money from parent to kid (single credit transaction visible to kid).
 */
public function sendMoney(Request $request)
{
    $request->validate([
        'kid_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:1',
    ]);

    $kid = User::where('id', $request->kid_id)
               ->where('parent_id', Auth::id())
               ->firstOrFail();

    // Create only one transaction – credit for kid
    Transaction::create([
        'parent_id' => Auth::id(),
        'kid_id'    => $kid->id,
        'amount'    => $request->amount,
        'type'      => 'debit', // kid receiving = credit
        'status'    => 'completed',
    ]);
    Transaction::create([
        'parent_id' => Auth::id(),
        'kid_id'    => $kid->id,
        'amount'    => $request->amount,
        'type'      => 'credit', // kid receiving = credit
        'status'    => 'completed',
    ]);

    return back()->with('success', 'Money sent successfully!');
}

}
