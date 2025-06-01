<?php

use App\Http\Controllers\Web\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Web\Admin\DashboardController as AdminDashboardController;
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
    Route::get('/feed/posts' , [FeedContentController::class , 'posts'])->name('feed.posts');

    //dashboard routes
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard.index');
    Route::get('/dashboard/posts', [DashboardController::class, 'posts'])->name('dashboard.posts');
    Route::post('/dashboard/post/store', [DashboardController::class, 'store']);
    Route::put('/dashboard/post/{id}', [DashboardController::class, 'update']);
    Route::delete('/dashboard/post/{id}', [DashboardController::class, 'destroy']);


    //logout
    Route::post('/logout' , [AuthController::class , 'logout'])->name('logout');
});


                        /**********Admin Routes *********/

Route::prefix(('admin'))->group(function () {

    Route::get('/login', [AdminAuthController::class, 'loginForm'])->name('adminLogin.form');
    Route::post('/login', [AdminAuthController::class, 'Adminlogin'])->name('admin.login');

    Route::middleware(['auth:admin'])->group(function () {
        //admin dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard/posts', [AdminDashboardController::class, 'posts'])->name('admin.dashboard.posts');
        Route::put('/dashboard/post/{id}', [AdminDashboardController::class, 'update']);
        Route::delete('/dashboard/post/{id}', [AdminDashboardController::class, 'destroy']);


        //logout
        Route::post('/logout', [AdminAuthController::class, 'adminLogout'])->name('admin.logout');
    });

});

