<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(middleware: ['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/add-card', [ProfileController::class, 'addCard'])->name('profile.addCard');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('admin.reservations.index');
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
Route::get('/reviews', function () {
    return view('reviews');
})->name('reviews');
Route::get('/user_reviews', function () {
    return view('user_reviews');
})->name('user_reviews');
Route::get('/edit_review/{id}', function ($id) {
    return view('edit_review', ['reviewId' => $id]);
})->name('edit_review');

Route::get('/rooms', function () {
    return view('rooms.room');  // Loads the room management page
})->name('rooms');


require __DIR__.'/auth.php';
