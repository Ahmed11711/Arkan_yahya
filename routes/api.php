<?php

use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Blog\BlogController;
   use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Kyc\KycController;
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
    Route::resource('users',UserController::class);
    Route::apiResource('blogs', BlogController::class)->names('blog');
});

 Route::get('ahmed',function(){
    return 's2s2';
 });

