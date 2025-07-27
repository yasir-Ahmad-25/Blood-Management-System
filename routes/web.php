<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\HospitalController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::middleware('custom.auth')->controller(AdminController::class)->group(function () {
    Route::get('/', 'index')->name('admin.index');

    // Donor Management Routes
    Route::get('donors', 'donors')->name('admin.donors');
    Route::get('create_donor','createDonor')->name('admin.create_donor');
    Route::post('record_donor','recordDonor')->name('admin.record_donor');
    Route::get('edit_donor/{id}', 'editDonor')->name('admin.edit_donor');
    Route::post('update_donor/{id}', 'updateDonor')->name('admin.update_donor');
    Route::get('delete_donor/{id}', 'deleteDonor')->name('admin.delete_donor');
    Route::get('get_donor_blood_type', 'getDonorBloodType')->name('admin.get_donor_blood_type');

    // Donation Management Routes 
    Route::get('donations', 'donations')->name('admin.donations');
    Route::get('create_donation', 'createDonation')->name('admin.create_donation');
    Route::post('record_donation', 'recordDonation')->name('admin.record_donation');
    Route::get('change_donation_status/{id}/status/{action}', 'change_donation_status')->name('admin.change_donation_status');

    // Blood Inventory Management Routes
    Route::get('blood_inventories', 'bloodInventories')->name('admin.blood_inventories');

    // Requests
    Route::get('requests_blood','requests_blood')->name('admin.requests_blood');
    Route::get('accept_request/{id}','accept_request')->name('admin.accept_request');
    Route::get('cancel_request/{id}','cancel_request')->name('admin.cancel_request');
    

    // Hospital Management Routes
    Route::get('hospitals', 'hospitals')->name('admin.hospitals');
    Route::get('create_hospital', 'createHospital')->name('admin.create_hospital');
    Route::post('record_hospital', 'recordHospital')->name('admin.record_hospital');
    Route::get('edit_hospital/{id}', 'editHospital')->name('admin.edit_hospital');
    Route::post('update_hospital/{id}', 'updateHospital')->name('admin.update_hospital');
    Route::get('delete_hospital/{id}', 'deleteHospital')->name('admin.delete_hospital');
    
    
    Route::get('report', 'report')->name('admin.report');
    // Add more admin routes as needed
    Route::get('logout', 'logout')->name('admin.logout');
});

// Hospital Routes
Route::middleware('custom.hospital_auth')->prefix('hospital')->controller(HospitalController::class)->group(function () {
    Route::get('logout', 'hospitalLogout')->name('hospital.logout');
    Route::get('/', 'hospitalDashboard')->name('hospital.dashboard');

    // Request Blood Routes
    Route::get('BloodRequests', 'BloodRequests')->name('hospital.BloodRequests');
    Route::get('create_BloodRequest', 'create_BloodRequest')->name('hospital.create_BloodRequest');
    Route::post('record_Bloodrequest', 'record_Bloodrequest')->name('hospital.record_Bloodrequest');
    Route::get('cancel_request/{id}', 'cancel_request')->name('hospital.cancel_request');

    // Stockout Routes
    Route::get('stockout','stockout')->name('hospital.stockout');
    Route::get('create_stockout','create_stockout')->name('hospital.create_stockout');
    Route::post('record_stockout','record_stockout')->name('hospital.record_stockout');
});

// Authentication Routes For Admin
Route::middleware('custom.guest')->controller(AuthenticationController::class)->group(function () {
    Route::get('login', 'hospitalLogin')->name('hospital.login');
    Route::post('hospitalAuthenticate', 'hospitalAuthenticate')->name('hospital.hospitalAuthenticate');
    Route::get('login', 'login')->name('auth.login');
    Route::post('authenticate', 'authenticate')->name('auth.authenticate');

    // Route::get('forgot-password', [AdminController::class, 'showForgotPasswordForm'])->name('admin.forgot_password');
    // Route::post('forgot-password', [AdminController::class, 'sendResetLink'])->name('admin.send_reset_link');

    // Route::get('reset-password/{token}', [AdminController::class, 'showResetPasswordForm'])->name('password.reset');
    // Route::post('reset-password', [AdminController::class, 'resetPassword'])->name('admin.reset_password_post');


    Route::get('forgot-password', [AdminController::class, 'showForgotPasswordForm'])->name('admin.forgot_password');
    Route::post('forgot-password', [AdminController::class, 'sendResetLink'])->name('admin.send_reset_link');

    Route::get('reset-password/{token}', [AdminController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AdminController::class, 'resetPassword'])->name('admin.reset_password_post');


});

// Authentication Routes For Hospital
Route::middleware('custom.hospital_guest')->prefix('hospital')->controller(HospitalController::class)->group(function () {
    Route::get('login', 'hospitalLogin')->name('hospital.login');
    Route::post('hospitalAuthenticate', 'hospitalAuthenticate')->name('hospital.hospitalAuthenticate');
});



