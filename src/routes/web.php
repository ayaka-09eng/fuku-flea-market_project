<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

Route::get('/email/verify', function () {
    return view('auth.verify_email');
})->middleware(['auth'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('profile.create');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back();
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/create', [UserController::class, 'create'])->name('profile.create');
    Route::post('/profile', [UserProfileController::class, 'store'])->name('profile.store');
    Route::get('/mypage', [UserProfileController::class, 'mypage'])->name('mypage');
    Route::get('/mypage/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/mypage/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/sell/create', [ItemController::class, 'create'])->name('sell.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('sell.store');
    Route::post('/items/{id}/like', [ItemController::class, 'toggleLike'])->name('items.like');
    Route::post('/item/{item_id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/purchase/address/{item_id}', [OrderController::class, 'editAddress'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item_id}', [OrderController::class, 'updateAddress'])->name('purchase.address.update');
    Route::get('/purchase/{item_id}', [OrderController::class, 'create'])->name('purchase.create');
    Route::post('/purchase/{item}', [OrderController::class, 'store'])->name('purchase.store');
});