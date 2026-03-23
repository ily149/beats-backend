<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeatController;
use App\Http\Controllers\BeatAssetController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\StreamController;

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public - browse
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);
Route::get('/producers', [ProducerController::class, 'index']);
Route::get('/producers/{id}', [ProducerController::class, 'show']);
Route::get('/beats/latest', [BeatController::class, 'latest']);
Route::get('/stream/{asset}', StreamController::class);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Beats
    Route::get('/beats', [BeatController::class, 'index']);
    Route::post('/beats', [BeatController::class, 'store']);
    Route::get('/beats/{beat}', [BeatController::class, 'show']);
    Route::delete('/beats/{beat}', [BeatController::class, 'destroy']);

    // Beat assets
    Route::post('/beats/{beat}/assets/upload', [BeatAssetController::class, 'upload']);
});
