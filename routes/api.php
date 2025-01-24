<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/author', [AuthorController::class, 'store']);
Route::post('/category', [CategoryController::class, 'store']);
Route::post('/book', [BookController::class, 'store']);
