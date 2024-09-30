<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookingController;

Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');

// Optional: Redirect the root URL to the bookings creation page
Route::get('/', function () {
    return redirect()->route('bookings.create');
});


