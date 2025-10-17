<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KidInvitationController extends Controller
{
    /**
     * 📨 Step 1 — Kid clicks email invitation link
     * e.g. /invite/{token}
     */
    public function acceptInvite($token)
    {
        // Find kid with this token
        $kid = User::where('invite_token', $token)
            ->where('role', 2)
            ->first();

        if (!$kid) {
            return redirect('/')->with('error', 'Invalid or expired invitation link.');
        }

        // Redirect to password setup form with token & email
        return redirect()->route('kid.resetpassword.form', ['token' => $token]);
    }

    /**
     * 🔐 Step 2 — Show the Set Password Form
     */
    public function showResetPasswordForm($token)
    {
        $kid = User::where('invite_token', $token)
            ->where('role', 2)
            ->first();

        if (!$kid) {
            return redirect('/')->with('error', 'Invalid or expired token.');
        }

        $email = $kid->email;

        return view('auth.resetpassword', compact('token', 'email'));
    }

    /**
     * 🔄 Step 3 — Handle password setup form submission
     */
    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $kid = User::where('invite_token', $token)
            ->where('role', 2)
            ->first();

        if (!$kid) {
            return redirect('/')->with('error', 'Invalid or expired token.');
        }

        // ✅ Update password & clear token
        $kid->password = Hash::make($request->password);
        $kid->invite_token = null; // prevent reuse
        $kid->save();

        // ✅ Auto login the kid after setting password
        Auth::login($kid);

        // ✅ Redirect to kid dashboard
        return redirect()->route('kid.dashboard')
            ->with('success', 'Password set successfully! Welcome to Mini Pocket.');
    }
}
