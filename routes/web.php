<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', function () {
        return view('register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/transactions', function () {
        return view('transactions');
    })->name('transactions');

    Route::get('/wallets', function () {
        return view('wallets');
    })->name('wallets');

    Route::get('/wallets/create', function () {
        return view('create-wallet');
    })->name('wallets.create');

    Route::get('/budgets', function () {
        return view('budgets');
    })->name('budgets');

    Route::get('/reports', function () {
        return view('reports');
    })->name('reports');

    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
});
