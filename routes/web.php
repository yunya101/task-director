<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InvitationsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\LoginMiddleware;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->name('login.')->middleware(LoginMiddleware::class)->group(function() {
    Route::get('login', 'login')->name('login');
    Route::get('register', 'register')->name('register');
    Route::post('login', 'auth')->name('auth');
    Route::post('logout', 'logout')->name('logout');
});

Route::middleware(['auth', 'verified'])->resource('users', UserController::class)->except(['store', 'create']);
Route::post('users.store', [UserController::class, 'store'])->name('users.store');

Route::middleware(['auth', 'verified'])->resource('groups', GroupController::class)->except(['show']);

Route::middleware(['auth', 'verified'])->resource('groups/{group}/tasks', TaskController::class)->except(['edit']);
Route::middleware(['auth', 'verified'])->prefix('groups/{group}/tasks/{task}/comments')->name('comments.')->controller(CommentController::class)
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
});

Route::get('verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('groups.index');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth', 'verified'])->controller(InvitationsController::class)->name('invitations.')->group(function() {
    Route::get('invitations', 'index')->name('index');
    Route::post('invitations/{group_id}', 'accept')->name('accept');
});