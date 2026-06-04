<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');

    Route::get('/services', function () {
        return view('customer.services');
    })->name('services');

    Route::get('/invoices', function () {
        return view('customer.invoices');
    })->name('invoices');

    Route::get('/payments', function () {
        return view('customer.payments');
    })->name('payments');

    Route::get('/tickets', function () {
        return view('customer.tickets');
    })->name('tickets');

    Route::get('/domains', function () {
        return view('customer.domains');
    })->name('domains');
});
