<?php
use App\Http\Controllers\HomeController;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\AppAccountController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SignupController;

Route::get('/home', [HomeController::class, 'index']);

Route::post('/contactmail', [HomeController::class, 'mail']);

Auth::routes();

Route::get('logout', [LoginController::class, 'logout']);

Route::get('/matrix', [HomeController::class, 'matrix']);

Route::get('/not-activated', [HomeController::class, 'notActivated']);

Route::get('/activationrequest', [HomeController::class, 'activationRequest']);

Route::get('/profile', [HomeController::class, 'profile']);

Route::post('/profile/{user}', [HomeController::class, 'update']);

Route::get('/training', [HomeController::class, 'training']);

Route::post('/user-accounts', [UserAccountController::class, 'store']);

Route::post('/user-accounts/{userAccount}', [UserAccountController::class, 'update']);

Route::get('/app-accounts', [AppAccountController::class, 'index'])->middleware('role:admin');

Route::post('/app-accounts', [AppAccountController::class, 'store'])->middleware('role:admin');

Route::get('/app-accounts/{appAccount}', [AppAccountController::class, 'destroy'])->middleware('role:admin');

Route::post('/app-accounts/{appAccount}', [AppAccountController::class, 'update'])->middleware('role:admin');

Route::get('/wallet', [WalletController::class, 'index']);

Route::post('/send-payment-request', [WalletController::class, 'sendPaymentRequest']);

Route::get('/pending', [AdminController::class, 'pending'])->middleware('role:admin');

// Route::get('/staff', [AdminController::class, 'staff'])->middleware('role:admin');

// Route::post('/staff', [AdminController::class, 'makeStaff'])->middleware('role:admin');

Route::get('/payment', [AdminController::class, 'payment'])->middleware('role:admin');

Route::post('/payment/{transaction}', [AdminController::class, 'paymentDone'])->middleware('role:admin');

Route::post('/activate-user', [AdminController::class, 'activateUser'])->middleware('role:admin');

Route::get('/transactions', [AdminController::class, 'transactions'])->middleware('role:admin');

Route::post('/upgrade', [AdminController::class, 'upgrade']);

Route::post('/fund', [AdminController::class, 'fund'])->middleware('role:admin');

Route::get('/checker', [AdminController::class, 'checkUser']);

Route::get('/verify/{reference}', [AdminController::class, 'verify']);

// Route::post('/register', [RegisterController::class, 'register'])->name('register_post');




Route::get('/signup', [SignupController::class, 'create'])->name('signup.create');
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');
