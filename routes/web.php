<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Parent\ParentController;
use App\Http\Controllers\Kid\KidController;
use App\Http\Controllers\Kid\KidInvitationController;
use App\Http\Controllers\Homepage\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

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

// 🏡 Start Page Route
Route::get('/', [HomeController::class, 'index'])->name('start.page');

// ====================================================
// 🏠 Landing Page
// ====================================================
Route::get('/start', function () {
    return view('welcome');
})->name('welcome');



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


// Show forgot password form
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

// Send email reset link
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

    // SHOW RESET PASSWORD FORM (GET)
Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// HANDLE RESET PASSWORD SUBMIT (POST)
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');


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


    Route::get('/kid/goals', [KidController::class, 'kidGoals'])->name('kid.goals'); // We'll add this below
    Route::post('/kid/goals/store', [KidController::class, 'storeGoal'])->name('goals.store');
    Route::post('/kid/goals/{goal}/add-savings', [KidController::class, 'addSavings'])->name('goals.addSavings');
    Route::get('/kid/goals/{goal}/details', [KidController::class, 'goalDetails'])->name('goals.details');
    Route::post('/kid/sendgoalpayment', [KidController::class, 'sendGoalPayment'])
    ->name('kid.sendgoalpayment');


    // 🎁 Gifts
// 🎁 Gifts
Route::get('/kid/gifts', [KidController::class, 'showGifts'])->name('kid.gifts');
Route::get('/kid/gifts/add', [KidController::class, 'addGiftPage'])->name('kid.gifts.addpage');
Route::post('/kid/gifts', [KidController::class, 'storeGift'])->name('kid.gifts.store');
Route::post('/kid/gifts/add', [KidController::class, 'addGiftSaving'])->name('kid.gifts.add');
Route::post('/kid/sendgiftmoney', [KidController::class, 'sendGiftMoney'])->name('kid.sendgiftmoney');
Route::post('/kid/sendtoparent', [KidController::class, 'kidSendToParent'])
    ->name('kid.sendtoparent');
Route::get('/kid/achievements', [KidController::class, 'achievements'])->name('kid.achievements');

});


// ====================================================
// ✉️ Kid Invitation & Password Reset
// ====================================================
Route::get('/invite/{token}', [KidInvitationController::class, 'acceptInvite'])
    ->name('kid.invite.accept');

Route::get('/kid/reset-password/{token}', [KidInvitationController::class, 'showResetPasswordForm'])
    ->name('kid.resetpassword.form');

Route::post('/kid/reset-password/{token}', [KidInvitationController::class, 'resetPassword'])
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



    // ➕ Store new kid
    Route::post('/kids/store', [ParentController::class, 'storeKid'])
        ->name('kids.store');

    // 🔁 Re-send invitation email
    Route::post('/kids/{id}/resend-invite', [ParentController::class, 'resendInvite'])
        ->name('kids.resend.invite');

    // 💰 Set kid daily limit
    Route::post('/kids/{id}/set-limit', [ParentController::class, 'setKidLimit'])
        ->name('kids.set.limit');

        Route::get('/parent/kid-management', [ParentController::class, 'kidManagement'])
    ->name('parent.kid.management');


        Route::get('/parent/transactions', [ParentController::class, 'transactionHistory'])
    ->name('parent.transactions');
Route::get('/parent/bankaccounts', [ParentController::class, 'bankAccounts'])->name('parent.bankaccounts');
Route::get('/parent/bankaccounts/add', [ParentController::class, 'addBankAccount'])->name('parent.addbankaccount');
Route::get('/parent/bankaccounts/add/{bank}', [ParentController::class, 'addSpecificBank'])->name('parent.addbankaccount.specific');
Route::post('/parent/bankaccounts/store', [ParentController::class, 'storeBankAccount'])->name('parent.add.bank');
Route::get('/parent/bankaccounts/select/{id}', [ParentController::class, 'selectBank'])->name('parent.select.bank');
Route::post('/parent/clear-bank-session', [ParentController::class, 'clearBankSession'])
    ->name('parent.clear.bank.session');

Route::post('/parent/bank/set-primary/{bankId}', [ParentController::class, 'setPrimaryBank'])->name('bank.setPrimary');
Route::post('/parent/bank/unset-primary/{bankId}', [ParentController::class, 'unsetPrimaryBank'])->name('bank.unsetPrimary');


    

    // 🧒 Store kid
    Route::post('/kids/store', [ParentController::class, 'storeKid'])->name('kids.store');

    // 💰 Set kid limit
    Route::post('/kids/{id}/set-limit', [ParentController::class, 'setKidLimit'])->name('kids.set.limit');

});