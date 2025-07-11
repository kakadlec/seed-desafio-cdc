<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CouponController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/author', [AuthorController::class, 'store']);
Route::post('/category', [CategoryController::class, 'store']);
Route::post('/book', [BookController::class, 'store']);
Route::get('/book/{id}', [BookController::class, 'retrieveById']);
Route::get('/books', [BookController::class, 'retrieve']);
Route::get('/product/{id}', [ProductController::class, 'details']);
Route::post('/country', [CountryController::class, 'store']);
Route::post('/state', [StateController::class, 'store']);
Route::post('/order', [OrderController::class, 'store']);
Route::post('/coupons', [CouponController::class, 'store']);



