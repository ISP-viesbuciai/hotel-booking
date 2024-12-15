<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserReviewsController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/add-card', [ProfileController::class, 'addCard'])->name('profile.addCard');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('admin.reservations.index');
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::post('/admin/users/reviews/{reviewId}/delete', [AdminController::class, 'deleteReview'])->name('admin.users.reviews.delete');
    Route::post('/admin/users/comments/{commentId}/delete', [AdminController::class, 'deleteComment'])->name('admin.users.comments.delete');
});

Route::get('/contact', function () {
    return view('contact');
});
Route::get('/email', function () {
    return view('email');
});
Route::get('/chat', function () {
    return view('chat');
});
Route::get('/chatList', function () {
    return view('chatList');
});

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::post('/reviews/{review}/comment', [ReviewController::class, 'storeComment'])->name('reviews.comment.store');

Route::post('/reviews/{review}/like', [ReviewController::class, 'likeReview'])->name('reviews.like');
Route::post('/comments/{comment}/like', [ReviewController::class, 'likeComment'])->name('comments.like');

Route::get('/my-reviews', [UserReviewsController::class, 'index'])->name('user.reviews.index');
Route::post('/my-reviews/update-review/{reviewId}', [UserReviewsController::class, 'updateReview'])->name('user.reviews.update');
Route::post('/my-reviews/delete-review/{reviewId}', [UserReviewsController::class, 'deleteReview'])->name('user.reviews.delete');

Route::post('/my-reviews/update-comment/{commentId}', [UserReviewsController::class, 'updateComment'])->name('user.comments.update');
Route::post('/my-reviews/delete-comment/{commentId}', [UserReviewsController::class, 'deleteComment'])->name('user.comments.delete');

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
