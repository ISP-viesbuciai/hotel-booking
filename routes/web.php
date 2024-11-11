<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/contact', function () {
    return view('contact');  // Return the contact view
});
Route::get('/email', function () {
    return view('email');  // Return the contact view
});
Route::get('/chat', function () {
    return view('chat');  // Return the contact view
});
Route::get('/chatList', function () {
    return view('chatList');  // Return the contact view
});
Route::get('/profile', function () {
    return view('profile');  // Return the contact view
});
Route::get('/rezervations', function () {
    return view('rezervations');  // Return the contact view
});

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

require __DIR__.'/auth.php';
