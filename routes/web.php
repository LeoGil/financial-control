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

    Route::resource('transactions', TransactionController::class)->only(['create', 'store']);

    // Remove index porque agora está sendo tratado pela rota aninhada
    Route::resource('credit_cards', CreditCardController::class)->except(['view', 'index']);

    // Rota aninhada para acessar os cartões de uma conta específica
    Route::prefix('accounts/{account}')->name('accounts.')->group(function () {
        Route::get('credit_cards', [CreditCardController::class, 'index'])->name('credit_cards.index');
        Route::get('statements', [StatementController::class, 'index'])->name('statements.index');
        Route::get('statements/{statement}/transactions', [TransactionController::class, 'index'])->name('statements.transactions');
        Route::patch('statements/{statement}/pay', [StatementController::class, 'pay'])->name('statements.pay');
        Route::delete('statements/installments/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('statements.installments.transactions.destroy');
    });

    Route::resource('accounts', AccountController::class)->except(['view']);
});
