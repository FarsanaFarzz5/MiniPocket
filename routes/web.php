<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Parent\ParentController;
use App\Http\Controllers\Kid\KidController;
use App\Http\Controllers\Kid\KidInvitationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Default redirect
Route::get('/', function () {
    return redirect()->route('login.form', ['role' => 1]);
});

// --------------------
// Auth / Registration
// --------------------
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// --------------------
// Kid dashboard & profile
// --------------------
Route::get('/kid/dashboard', [KidController::class, 'dashboard'])
    ->name('kid.dashboard')
    ->middleware('auth');

Route::get('/kid/edit', [KidController::class, 'editProfile'])
    ->name('kid.edit')
    ->middleware('auth');

Route::post('/kid/update', [KidController::class, 'updateProfile'])
    ->name('kid.update')
    ->middleware('auth');

// NEW: kid send money (debit)
Route::post('/kid/send-money', [KidController::class, 'sendMoney'])
    ->name('kid.send.money')
    ->middleware('auth');

// --------------------
// Kid invitation / password setup
// --------------------
Route::get('/invite/{token}', [KidInvitationController::class, 'acceptInvite'])
    ->name('kid.invite.accept');

Route::get('/reset-password/{token}', [KidInvitationController::class, 'showResetPasswordForm'])
    ->name('kid.resetpassword.form');

Route::post('/reset-password/{token}', [KidInvitationController::class, 'resetPassword'])
    ->name('kid.resetpassword.submit');

// --------------------
// Parent actions
// --------------------
Route::get('/parent', [ParentController::class, 'dashboard'])
    ->name('dashboard.parent')
    ->middleware('auth');

Route::post('/parent/add-profile', [ParentController::class, 'addProfile'])
    ->name('parent.add.profile')
    ->middleware('auth');

Route::post('/parent/send-money', [ParentController::class, 'sendMoney'])
    ->name('parent.send.money')
    ->middleware('auth');

Route::post('/kids/store', [ParentController::class, 'storeKid'])
    ->name('kids.store')
    ->middleware('auth');

Route::post('/kids/{id}/resend-invite', [ParentController::class, 'resendInvite'])
    ->name('kids.resend.invite')
    ->middleware('auth');

