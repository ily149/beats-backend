<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeatController;
use App\Http\Controllers\BeatAssetController;

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

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