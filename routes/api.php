<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\Api\Kyc\KycController;
use App\Http\Controllers\Api\Blogs\BlogController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Deposit\DepositController;
use App\Http\Controllers\Api\Service\ServiceController;
use App\Http\Controllers\Api\Withdraw\WithdrawController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Auth\VerificationCodeController;

Route::prefix('v1')->group(function () {

    // Auth routes
    Route::prefix('Auth')->group(function () {
        Route::post('create-account', [RegisterController::class, 'createUser']);
        Route::post('login', [RegisterController::class, 'login']);
        Route::post('login-google', [RegisterController::class, 'googleLogin']);
        Route::post('send-otp', [VerificationCodeController::class, 'sendOtp']);
        Route::post('verify-otp', [VerificationCodeController::class, 'verifyOtp']);
        Route::post('forgot-password', [ForgetPasswordController::class, 'sendResetLink']);
        Route::post('reset-password', [ForgetPasswordController::class, 'reset']);
});

    // KYC route
    Route::post('kyc', [KycController::class, 'upload']);

    // Blog routes
    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('blogs/{id}', [BlogController::class, 'show']);
    Route::get('blogs-all', [BlogController::class, 'all']);
    Route::get('service', [ServiceController::class, 'index']);

    // middleware
    Route::middleware(JwtMiddleware::class)->group(function () {
    Route::get('deposit',[DepositController::class,'deposit']);
    Route::get('check-deposit',[DepositController::class,'checkDeposit']);
    // withdraw
    Route::post('create-withdraw',[WithdrawController::class,'store']);
    Route::get('withdraw',[WithdrawController::class,'withdraw']);
    });

////

});

require __DIR__.'/admin.php';
