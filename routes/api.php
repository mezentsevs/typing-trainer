<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('lessons')->group(function () {
        Route::get('/{language}/{lessonNumber}', [LessonController::class, 'show']);
        Route::post('/generate', [LessonController::class, 'generate']);
        Route::post('/progress', [LessonController::class, 'saveProgress']);
    });

    Route::prefix('test')->group(function () {
        Route::get('/text', [TestController::class, 'getTestText']);
        Route::post('/upload', [TestController::class, 'uploadText']);
        Route::post('/result', [TestController::class, 'saveResult']);
    });
});
