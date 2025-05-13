<?php

use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\Authenticator;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store']);
Route::post('logout', [LoginController::class, 'destroy'])->name('login.logout');

Route::get('register', [UsersController::class, 'create'])->name('users.create');
Route::post('register', [UsersController::class, 'store'])->name('users.store');

Route::middleware(Authenticator::class)->group(function () {
    Route::get('/', function () {
        return redirect('/accounts');
    });

    Route::resource('statements', StatementController::class)->except(['create', 'edit']);
    Route::resource('transactions', TransactionController::class)->only(['create', 'store']);

    // Remove index porque agora está sendo tratado pela rota aninhada
    Route::resource('credit_cards', CreditCardController::class)->except(['view', 'index']);

    // Rota aninhada para acessar os cartões de uma conta específica
    Route::get('accounts/{account}/credit_cards', [CreditCardController::class, 'index'])
        ->name('accounts.credit_cards.index');

    Route::resource('accounts', AccountController::class)->except(['view']);
});
