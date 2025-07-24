<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::prefix('lessons')->group(function () {
        Route::get('/{language}/{lessonNumber}', [LessonController::class, 'show'])->name('api.lessons.show');
        Route::post('/generate', [LessonController::class, 'generate'])->name('api.lessons.generate');
        Route::post('/result', [LessonController::class, 'saveResult'])->name('api.lessons.result');
    });

    Route::prefix('test')->group(function () {
        Route::get('/text', [TestController::class, 'getText'])->name('api.test.text');
        Route::post('/upload', [TestController::class, 'uploadText'])->name('api.test.upload');
        Route::post('/result', [TestController::class, 'saveResult'])->name('api.test.result');
    });
});
