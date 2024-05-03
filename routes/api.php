<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryBookController;
use App\Http\Controllers\Api\AuthController;





Route::apiResource('authors', AuthorController::class);
Route::apiResource('publishers', PublisherController::class);
Route::apiResource('books',BookController::class);
Route::apiResource('categories', CategoryBookController::class);
// Route::get('/categories', [CategoryBookController::class, 'index']);
// Route::post('/categories', [CategoryBookController::class, 'store']);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
    
// });
