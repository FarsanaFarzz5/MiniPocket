<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function showResetForm(Request $request)
    {
        return view('auth.resetpassword', [
            'token' => $request->query('token'),
            'email' => $request->query('email')
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'token'                 => 'required',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)
                    ->where('invite_token', $request->token)
                    ->firstOrFail();

        $user->password = Hash::make($request->password);
        $user->invite_token = null; // clear token after use
        $user->save();

        return redirect()->route('login.form')->with('success', 'Password set successfully. You can now login.');
    }
}
