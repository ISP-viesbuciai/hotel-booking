<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomsController;

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

// ROOMS ROUTES START
Route::get('/rooms', [RoomsController::class, 'index'])->name('rooms.index');
Route::post('/rooms', [RoomsController::class, 'store'])->name('rooms.store');
Route::put('/rooms/{id}', [RoomsController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{id}', [RoomsController::class, 'destroy'])->name('rooms.destroy');

// Route to view free rooms by date or period
Route::get('/rooms/free', [RoomsController::class, 'showFreeRooms'])->name('rooms.free');

// Route for automatic group allocation
Route::post('/rooms/allocate-group', [RoomsController::class, 'autoAllocateForGroup'])->name('rooms.allocate-group');

// ROOMS ROUTES END


require __DIR__.'/auth.php';
