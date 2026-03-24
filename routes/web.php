<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

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
