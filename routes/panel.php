<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SettingsController;

Route::middleware('auth')->group(function () {

    // Müşteriler
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Teklif işlemleri
    Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
    Route::get('/offers/create', [OfferController::class, 'create'])->name('offers.create');
    Route::post('/offers', [OfferController::class, 'store'])->name('offers.store');
    Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offers.show');
    Route::delete('/offers/{offer}', [OfferController::class, 'destroy'])
        ->name('offers.destroy');

    Route::get('/offers/{offer}/pdf', [OfferController::class, 'pdf'])->name('offers.pdf');

    // Ayarlar
    Route::get('/settings', [SettingsController::class, 'edit'])
        ->name('settings.edit');

    Route::put('/settings', [SettingsController::class, 'update'])
        ->name('settings.update');

});
