<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ReportController;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', function () {
        return view('register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');

});

Route::view('/help', 'info.help')->name('help');
Route::view('/privacy', 'info.privacy')->name('privacy');
Route::view('/security', 'info.security')->name('security');

Route::middleware(['auth', 'nocache'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('search.suggest');

    Route::get('/wallets', [WalletController::class, 'index'])->name('wallets');
    Route::get('/wallets/create', [WalletController::class, 'create'])->name('wallets.create');
    Route::get('/wallets/{wallet}', [WalletController::class, 'show'])->name('wallets.show');
    Route::post('/wallets', [WalletController::class, 'store'])->name('wallets.store');
    Route::get('/wallets/{wallet}/edit', [WalletController::class, 'edit'])->name('wallets.edit');
    Route::put('/wallets/{wallet}', [WalletController::class, 'update'])->name('wallets.update');
    Route::delete('/wallets/{wallet}', [WalletController::class, 'destroy'])->name('wallets.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets');
    Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::put('/budgets/{budget}', [BudgetController::class, 'update'])->name('budgets.update');
    Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/download/pdf', [ReportController::class, 'downloadPdf'])->name('reports.pdf');
    Route::get('/reports/download/excel', [ReportController::class, 'downloadExcel'])->name('reports.excel');

    Route::post('/notifications/mark-read', function (\Illuminate\Http\Request $request) {
        $request->user()->forceFill([
            'notif_read_at' => now(),
        ])->save();

        return response()->json(['ok' => true]);
    })->name('notifications.mark-read');

    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/onboarding/complete', [ProfileController::class, 'completeOnboarding'])->name('onboarding.complete');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
