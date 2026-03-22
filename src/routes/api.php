<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeatController;
use App\Http\Controllers\BeatAssetController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ProducerController;

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/beats/latest', [BeatController::class, 'latest']);
Route::get('/producers', [ProducerController::class, 'index']);
Route::get('/genres', [GenreController::class, 'index']);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Beats
    Route::get('/beats', [BeatController::class, 'index']);
    Route::post('/beats', [BeatController::class, 'store']);
    Route::get('/beats/{beat}', [BeatController::class, 'show']);

    // Beat assets
    Route::post('/beats/{beat}/assets/upload', [BeatAssetController::class, 'upload']);
});