<?php

use Illuminate\Support\Facades\Route;
use App\Models\Customer;
use App\Models\Offer;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $customerCount = Customer::count();
        $offerCount = Offer::count();

        $recentOffers = Offer::with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'customerCount',
            'offerCount',
            'recentOffers'
        ));
    })->name('dashboard');
});

require __DIR__ . '/panel.php';
