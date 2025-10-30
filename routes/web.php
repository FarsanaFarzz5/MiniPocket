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
| These routes are loaded by the RouteServiceProvider and all
| of them will be assigned to the "web" middleware group.
|
*/

// ====================================================
// 🏠 Landing Page
// ====================================================
Route::get('/', function () {
    return view('welcome'); // Mini Pocket login/signup landing page
});


// ====================================================
// 🔐 Authentication Routes
// ====================================================
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


// ====================================================
// 👦 Kid Dashboard & Profile Routes
// ====================================================
Route::middleware(['auth'])->group(function () {

    // Kid Dashboard
    Route::get('/kid/dashboard', [KidController::class, 'dashboard'])
        ->name('kid.dashboard');

    // ✏️ Edit Kid Profile
    Route::get('/kid/edit', [KidController::class, 'editKid'])
        ->name('kid.edit');

    // 💾 Update Kid Profile
    Route::post('/kid/update', [KidController::class, 'updateKid'])
        ->name('kid.update');

    // 💸 Spend Money (Kid)
    Route::post('/kid/send-money', [KidController::class, 'sendMoney'])
        ->name('kid.send.money');

    Route::get('/kid/scan-qr', [KidController::class, 'scanQR'])->name('kid.scanqr');

    Route::get('/kid/pay', [KidController::class, 'pay'])->name('kid.pay');


    Route::get('/kid/transactions', [KidController::class, 'kidTransactions'])
    ->name('kid.transactions');

    Route::get('/kid/moneytransfer', [KidController::class, 'moneyTransferPage'])->name('kid.moneytransfer');

});


// ====================================================
// ✉️ Kid Invitation & Password Reset
// ====================================================
Route::get('/invite/{token}', [KidInvitationController::class, 'acceptInvite'])
    ->name('kid.invite.accept');

Route::get('/reset-password/{token}', [KidInvitationController::class, 'showResetPasswordForm'])
    ->name('kid.resetpassword.form');

Route::post('/reset-password/{token}', [KidInvitationController::class, 'resetPassword'])
    ->name('kid.resetpassword.submit');


// ====================================================
// 👨‍👧 Parent Routes (Requires Authentication)
// ====================================================
Route::middleware('auth')->group(function () {

    // 🏠 Dashboard (parent info, summary)
    Route::get('/parent', [ParentController::class, 'dashboard'])
        ->name('dashboard.parent');

    // 💰 Send Money Page (Kid List)
    Route::get('/parent/send-money', [ParentController::class, 'showSendMoneyPage'])
        ->name('parent.sendmoney.page');

    // 💵 Individual Kid Payment Page
    Route::get('/parent/send-money/{kid}', [ParentController::class, 'showKidPaymentPage'])
        ->name('parent.pay.kid.page');

    // 💸 Send money to a kid (form submission)
    Route::post('/parent/send-money', [ParentController::class, 'sendMoney'])
        ->name('parent.send.money');

    // ✏️ Edit Profile Page
    Route::get('/parent/edit-profile', [ParentController::class, 'editProfile'])
        ->name('parent.editprofile');

    // 🔄 Update Profile (Form Submission)
    Route::post('/parent/update-profile', [ParentController::class, 'updateProfile'])
        ->name('parent.update.profile');

    // 👦 Add Kid page (form)
    Route::get('/parent/add-kid', [ParentController::class, 'addKid'])
        ->name('parent.addkid');

    // 📋 Kid Details page
    Route::get('/parent/kid-details', [ParentController::class, 'kidDetails'])
        ->name('parent.kiddetails');

    // ➕ Store new kid
    Route::post('/kids/store', [ParentController::class, 'storeKid'])
        ->name('kids.store');

    // 🔁 Re-send invitation email
    Route::post('/kids/{id}/resend-invite', [ParentController::class, 'resendInvite'])
        ->name('kids.resend.invite');

    // 💰 Set kid daily limit
    Route::post('/kids/{id}/set-limit', [ParentController::class, 'setKidLimit'])
        ->name('kids.set.limit');

        Route::get('/parent/transactions', [ParentController::class, 'transactionHistory'])
    ->name('parent.transactions');
Route::get('/parent/bankaccounts', [ParentController::class, 'bankAccounts'])->name('parent.bankaccounts');
Route::get('/parent/bankaccounts/add', [ParentController::class, 'addBankAccount'])->name('parent.addbankaccount');
Route::get('/parent/bankaccounts/add/{bank}', [ParentController::class, 'addSpecificBank'])->name('parent.addbankaccount.specific');
Route::post('/parent/bankaccounts/store', [ParentController::class, 'storeBankAccount'])->name('parent.add.bank');
Route::get('/parent/bankaccounts/select/{id}', [ParentController::class, 'selectBank'])->name('parent.select.bank');
Route::post('/parent/clear-bank-session', [ParentController::class, 'clearBankSession'])
    ->name('parent.clear.bank.session');
});