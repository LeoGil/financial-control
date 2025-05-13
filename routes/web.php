<?php

use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\Authenticator;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store']);
Route::post('logout', [LoginController::class, 'destroy'])->name('login.logout');

Route::get('register', [UsersController::class, 'create'])->name('users.create');
Route::post('register', [UsersController::class, 'store'])->name('users.store');

Route::middleware(Authenticator::class)->group(function () {
    Route::get('/', function () {
        return redirect('/statements');
    });

    Route::resource('statements', StatementController::class)
        ->except(['create', 'edit']);

    Route::resource('transactions', TransactionController::class)
        ->only(['create', 'store']);

    Route::resource('credit_cards', CreditCardController::class)
        ->except(['view']);
});
