<?php

use App\Http\Controllers\ApiControllers\DonorController;
use App\Http\Controllers\ApiControllers\HospitalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register-donor', [DonorController::class, 'register']);
Route::post('Login-donor', [DonorController::class, 'Login']);
Route::get('donors', [DonorController::class, 'index']);
Route::put('donors/{id}', [DonorController::class, 'update']);



// Hospital
Route::get('hospitals', [HospitalController::class, 'index']);
Route::get('hospital_blood_inventory/{id}', [HospitalController::class, 'bloodInventory']);