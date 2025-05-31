<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\User\AuthController;
use App\Http\Controllers\Web\User\DashboardController;
use App\Http\Controllers\Web\User\FeedContentController;
use Illuminate\Support\Facades\Route;

//home page public routes
Route::get('/', [HomeController::class , 'home'])->name('home');
Route::get('/login', [HomeController::class , 'login'])->name('login.form');
Route::get('/register', [HomeController::class , 'register'])->name('register.form');

// User public Routes
Route::post('/register' , [AuthController::class , 'register'])->name('register');
Route::post('/login' , [AuthController::class , 'login'])->name('login');


//auth routes
Route::middleware('auth')->group(function () {

    //feed
    Route::get('/feed' , [FeedContentController::class , 'index'])->name('feed.index');

    //dashboard routes
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard.index');
    Route::post('/dashboard/post/create', [DashboardController::class , 'store'])->name('dashboard.store');
    Route::get('/dashboard/post/{post}/edit', [DashboardController::class , 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/post/{post}', [DashboardController::class , 'update'])->name('dashboard.update');
    Route::delete('/dashboard/post/{post}', [DashboardController::class , 'destroy'])->name('dashboard.destroy');

    //logout
    Route::post('/logout' , [AuthController::class , 'logout'])->name('logout');
});
