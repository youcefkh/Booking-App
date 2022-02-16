<?php

use App\Models\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\BookableController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\BookablePriceController;
use App\Http\Controllers\Api\UserBookablesController;
use App\Http\Controllers\Api\UserFavoritesController;
use App\Http\Controllers\Api\BookableReviewController;
use App\Http\Controllers\Api\BookingByReviewController;
use App\Http\Controllers\Api\UpdateCoverImageController;
use App\Http\Controllers\Api\UpdateProfileImageController;
use App\Http\Controllers\Api\BookableAvailabilityController;
use App\Http\Controllers\Api\FavoriteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('bookables', BookableController::class);
Route::get('bookables/{id}/availability', BookableAvailabilityController::class)->name('bookables.availability');
Route::get('bookables/{id}/reviews', BookableReviewController::class)->name('bookables.reviews');
Route::get('bookables/{id}/price', BookablePriceController::class)->name('bookables.price');


Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/{id}/create', [CartController::class, 'create'])->name('cart.create');
Route::post('cart/{id}/delete', [CartController::class, 'delete'])->name('cart.delete');


Route::get('users/{id}/bookables', UserBookablesController::class);
Route::post('users/infos',[ UserController::class, 'updateInfos']);
Route::post('users/password', [UserController::class, 'updatePassword']);
Route::get('users/{id}/favorites', UserFavoritesController::class);

Route::post('favorites/{id}/create', [FavoriteController::class, 'create']);
Route::post('favorites/{id}/delete', [FavoriteController::class, 'delete']);


Route::apiResource('reviews', ReviewController::class)->only(['show', 'store']);
Route::get('booking-by-review/{key}', BookingByReviewController::class);

Route::post('checkout', CheckoutController::class)->name('checkout');

Route::post('profile-image', UpdateProfileImageController::class);
Route::post('cover-image', UpdateCoverImageController::class);

