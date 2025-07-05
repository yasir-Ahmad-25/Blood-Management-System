<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::middleware('custom.auth')->controller(AdminController::class)->group(function () {
    Route::get('dashboard', 'index')->name('admin.index');

    // Donor Management Routes
    Route::get('donors', 'donors')->name('admin.donors');
    Route::get('create_donor','createDonor')->name('admin.create_donor');
    Route::post('record_donor','recordDonor')->name('admin.record_donor');
    Route::get('edit_donor/{id}', 'editDonor')->name('admin.edit_donor');
    Route::post('update_donor/{id}', 'updateDonor')->name('admin.update_donor');
    Route::get('delete_donor/{id}', 'deleteDonor')->name('admin.delete_donor');
    Route::get('get_donor_blood_type', 'getDonorBloodType')->name('admin.get_donor_blood_type');

    // Donation Management Routes
    Route::get('create_donation', 'createDonation')->name('admin.create_donation');
    Route::post('record_donation', 'recordDonation')->name('admin.record_donation');
    // Add more admin routes as needed
    Route::get('logout', 'logout')->name('admin.logout');
});

// Authentication Routes
Route::middleware('custom.guest')->controller(AuthenticationController::class)->group(function () {
    Route::get('login', 'login')->name('auth.login');
    Route::post('authenticate', 'authenticate')->name('auth.authenticate');
});