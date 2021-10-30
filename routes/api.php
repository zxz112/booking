<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Bookable;
use App\Http\Controllers\Api\BookableController;
use App\Http\Controllers\Api\BookingAvailableController;
use App\Http\Controllers\Api\ReviewListController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\BookingByReviewKey;
use App\Http\Controllers\Api\PriceForBookable;
use App\Http\Controllers\Api\CheckoutController;

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



Route::get('/bookables',  [BookableController::class, 'index']);

Route::get('/bookables/{id}', [BookableController::class, 'show']);
Route::get('/bookables/{id}/available', BookingAvailableController::class);
Route::get('/bookables/{id}/review', ReviewListController::class);
Route::get('/bookables/{key}/booking', BookingByReviewKey::class);
Route::get('/bookables/{key}/price', PriceForBookable::class);
Route::post('checkout', CheckoutController::class);
Route::apiResource('reviews', ReviewController::class)->only(['show', 'store']);
