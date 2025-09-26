<?php

namespace App\Http\Controllers\Kid;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KidInvitationController extends Controller
{
    /**
     * Step 1: Kid clicks the invitation link.
     * Redirect them to reset-password form instead of logging them in.
     */
    public function acceptInvite($token)
    {
        // Verify token exists
        $kid = User::where('invite_token', $token)->firstOrFail();

        // Do not clear token or log in yet; just send to reset password form
        return redirect()->route('kid.resetpassword.form', ['token' => $token]);
    }

    /**
     * Step 2: Show reset password form for the invited kid.
     */
    public function showResetPasswordForm($token)
    {
        $kid = User::where('invite_token', $token)->firstOrFail();

        return view('auth.resetpassword', [
            'token' => $token,
            'email' => $kid->email,
        ]);
    }

    /**
     * Step 3: Handle reset password submission, update password and log kid in.
     */
public function resetPassword(Request $request, $token)
{
    $validator = Validator::make($request->all(), [
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $kid = User::where('invite_token', $token)->firstOrFail();

    // Update password & clear invite token
    $kid->password = Hash::make($request->password);
    $kid->invite_token = null;
    $kid->save();

    // Log them in
    Auth::login($kid);

    // ✅ redirect to an existing route name
    return redirect()->route('kid.dashboard')
        ->with('success', 'Password set successfully. Welcome!');
}

}
