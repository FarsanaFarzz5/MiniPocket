<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\Models\User;

class KidController extends Controller
{
    /**
     * Show kid dashboard with balance and transactions.
     */
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();

        // Role 2 = Kid
        if ($user->role != 2) {
            abort(403, 'Unauthorized');
        }

        /**
         * In the DB we always store “debit” when parent sends money.
         * For the kid view we treat those as “credit”.
         */

        // Money received from parent (in DB stored as debit but for kid we treat as credit)
        $receivedMoney = Transaction::where('kid_id', $user->id)
            ->where('type', 'credit') // stored as debit in DB
            ->sum('amount');

        // Money sent by kid (actual debit transactions created by kid)
        $sentMoney = Transaction::where('kid_id', $user->id)
            ->where('type', 'debit')
            ->whereNotNull('description') // optional filter for kid’s own spending
            ->sum('amount');

        // Available balance
        $balance = $receivedMoney - $sentMoney;

        // Fetch all transactions (latest first) and flip type for display
        $transactions = Transaction::where('kid_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($t) {
                // flip type for display only
                if ($t->parent_id && $t->type === 'debit') {
                    $t->display_type = 'credit';
                } else {
                    $t->display_type = $t->type;
                }
                return $t;
            });

        return view('dashboard.kid', compact(
            'user',
            'receivedMoney',
            'sentMoney',
            'balance',
            'transactions'
        ));
    }

    /**
     * Show the profile edit form.
     */
    public function editProfile()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role != 2) {
            abort(403, 'Unauthorized');
        }

        return view('dashboard.kid_edit', compact('user'));
    }

    /**
     * Update kid profile.
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role != 2) {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'first_name'  => 'required|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'phone_no'    => 'nullable|string|max:15',
            'dob'         => 'nullable|date',
            'gender'      => 'nullable|in:male,female,other',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle profile image upload
        if ($request->hasFile('profile_img')) {
            $user->profile_img = $request->file('profile_img')
                ->store('profile_images', 'public');
        }

        // Update profile fields
        $user->first_name  = $request->first_name;
        $user->second_name = $request->second_name;
        $user->phone_no    = $request->phone_no;
        $user->dob         = $request->dob;
        $user->gender      = $request->gender;

        $user->save();

        return redirect()->route('kid.dashboard')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Kid sends money (creates a debit transaction).
     */
/**
 * Kid sends money (creates a debit transaction for kid and a credit for parent).
 */
public function sendMoney(Request $request)
{
    /** @var User $user */
    $user = Auth::user();

    if ($user->role != 2) {
        abort(403, 'Unauthorized');
    }

    $request->validate([
        'amount'      => 'required|numeric|min:1',
        'description' => 'nullable|string|max:255',
    ]);

    $parentId = $user->parent_id;

    if (!$parentId) {
        return back()->withErrors(['parent' => 'No parent assigned. Cannot send money.']);
    }

    // 1. Debit transaction for kid (money out)
    Transaction::create([
        'parent_id'   => $parentId,
        'kid_id'      => $user->id,
        'amount'      => $request->amount,
        'type'        => 'debit', // kid's money going out
        'status'      => 'completed',
        'description' => $request->description,
    ]);

    // 2. Credit transaction for parent (money in)
    // Transaction::create([
    //     'parent_id'   => $parentId,
    //     'kid_id'      => $user->id,
    //     'amount'      => $request->amount,
    //     'type'        => 'credit', // parent's money coming in
    //     'status'      => 'completed',
    //     'description' => $request->description,
    // ]);

    return back()->with('success', 'Amount sent successfully!');
}

}
