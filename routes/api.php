<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\User\AuthController as UserAuthController;
use App\Http\Controllers\Api\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Api\User\FeedContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix(('admin'))->group(function () {

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:admin-api'])->group(function () {

    Route::get('dashboard/posts', [DashboardController::class, 'posts']);
    Route::get('dashboard/posts/{id}', [DashboardController::class, 'getPostById']);
    Route::post('dashboard/post/{id}', [DashboardController::class, 'update']);
    Route::delete('dashboard/post/{id}', [DashboardController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});


});
Route::prefix(('user'))->group(function () {
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/register', [UserAuthController::class, 'register']);

Route::middleware(['auth:user-api'])->group(function () {
    // User Feed Routes
    Route::get('/feed', [FeedContentController::class, 'index']);

    // User Dashboard Routes
    Route::get('dashboard/posts', [UserDashboardController::class, 'posts']);
    Route::get('dashboard/posts/{id}', [UserDashboardController::class, 'getPostById']);
    Route::post('dashboard/post/store', [UserDashboardController::class, 'store']);
    Route::post('dashboard/post/{id}', [UserDashboardController::class, 'update']);
    Route::delete('dashboard/post/{id}', [UserDashboardController::class, 'destroy']);

    Route::post('/logout', [UserAuthController::class, 'logout']);
});

});
