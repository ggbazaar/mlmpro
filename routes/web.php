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
use App\Http\Controllers\TreeController;

Route::get('/tree', [TreeController::class, 'showTree'])->name('tree.view');
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');
Route::get('/signin', [SignupController::class, 'signin'])->name('signup.signin');


