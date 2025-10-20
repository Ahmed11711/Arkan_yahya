<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Kyc\KycController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Auth\VerificationCodeController;
use App\Http\Controllers\Api\Blogs\BlogController;
use App\Http\Controllers\Api\Service\ServiceController;

Route::prefix('v1/Auth')->group(function () {

    Route::post('create-account', [RegisterController::class, 'createUser']);
    Route::post('login', [RegisterController::class, 'login']);
    Route::post('send-otp', [VerificationCodeController::class, 'sendOtp']);
    Route::post('verify-otp', [VerificationCodeController::class, 'verifyOtp']);
    Route::post('forgot-password', [ForgetPasswordController::class, 'sendResetLink']);
    Route::post('reset-password', [ForgetPasswordController::class, 'reset']);
});

Route::prefix('v1')->group(function () {
Route::post('kyc', [KycController::class, 'upload']);

    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('blogs/{id}', [BlogController::class, 'show']);
    Route::get('blogs-all', [BlogController::class, 'all']);
    Route::get('service', [ServiceController::class, 'index']);
});
require __DIR__.'/admin.php'; 
