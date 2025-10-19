<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Wallet\WalletController;
use App\Http\Controllers\Admin\Blogs\BlogsController;
use App\Http\Controllers\Admin\Service\ServiceController;
use App\Http\Controllers\Api\Kyc\KycController;
   use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Admin\Blog\BlogController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Auth\VerificationCodeController;

Route::prefix('Auth')->group(function () {

    Route::post('create-account', [RegisterController::class, 'createUser']);
    Route::post('login', [RegisterController::class, 'login']);
    Route::post('send-otp', [VerificationCodeController::class, 'sendOtp']);
    Route::post('verify-otp', [VerificationCodeController::class, 'verifyOtp']);
    Route::post('forgot-password', [ForgetPasswordController::class, 'sendResetLink']);
    Route::post('reset-password', [ForgetPasswordController::class, 'reset']);

});

Route::post('kyc',[KycController::class,'upload']);
 
Route::prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class)->names('user');
 
    Route::apiResource('services', ServiceController::class)->names('service');
    Route::apiResource('blogs', BlogsController::class)->names('blogs');
    Route::apiResource('wallets', WalletController::class)->names('wallet');
});

 