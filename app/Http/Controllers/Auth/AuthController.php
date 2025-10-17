<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Show the parent registration form (GET /register)
     */
    public function showRegisterForm(Request $request)
    {
        // if ($request->get('role') != 1) {
        //     abort(403, 'Unauthorized');
        // }

        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    /**
     * Handle parent registration (POST /register)
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'  => 'required|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'email'       => 'required|string|email|max:100|unique:users,email',
            'phone_no'    => 'nullable|string|max:15',
            'password'    => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create parent user
        $user = User::create([
            'first_name'  => $request->first_name,
            'second_name' => $request->second_name,
            'email'       => $request->email,
            'phone_no'    => $request->phone_no,
            'password'    => Hash::make($request->password),
            'role'        => 1, // parent
            'parent_id'   => null,
        ]);

        Auth::login($user);

        return redirect()
            ->route('dashboard.parent')
            ->with('success', 'Parent registered successfully');
    }

    /**
     * Show login form for parent or kid
     */
    public function showLoginForm(Request $request)
    {
        $role = $request->get('role'); // may be null
        return view('auth.login', compact('role'));
    }

    /**
     * Handle login submit
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->role == 1) {
                return redirect()
                    ->route('dashboard.parent')
                    ->with('success', 'Login successful');
            } else {
                return redirect()
                    ->route('kid.dashboard')
                    ->with('success', 'Login successful');
            }
        }

        // Authentication failed
        return redirect()->back()->withErrors(['error' => 'Invalid credentials.']);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $role = Auth::check() ? Auth::user()->role : null;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form', ['role' => $role == 2 ? 2 : 1]);
    }
}
