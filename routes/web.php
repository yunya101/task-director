<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->name('login.')->group(function() {
    Route::get('login', 'login')->name('login');
    Route::get('register', 'register')->name('register');
    Route::post('login', 'auth')->name('auth');
});

Route::middleware(AuthMiddleware::class)->resource('users', UserController::class);
Route::middleware(AuthMiddleware::class)->resource('groups', GroupController::class);
Route::middleware(AuthMiddleware::class)->prefix('groups/{group}')->resource('tasks', TaskController::class);
Route::middleware(AuthMiddleware::class)->prefix('groups/{group}/tasks/{task}/comments')->name('comments.')->controller(CommentController::class)
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });