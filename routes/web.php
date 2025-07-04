<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::middleware('custom.auth')->controller(AdminController::class)->group(function () {
    Route::get('dashboard', 'index')->name('admin.index');
    Route::get('logout', 'logout')->name('admin.logout');
});

// Authentication Routes
Route::middleware('custom.guest')->controller(AuthenticationController::class)->group(function () {
    Route::get('login', 'login')->name('auth.login');
    Route::post('authenticate', 'authenticate')->name('auth.authenticate');
});