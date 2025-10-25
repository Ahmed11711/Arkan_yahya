<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\Api\Kyc\KycController;
use App\Http\Controllers\Api\Blogs\BlogController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Deposit\DepositController;
use App\Http\Controllers\Api\Service\ServiceController;
use App\Http\Controllers\Api\UserPlan\UserPlanController;
use App\Http\Controllers\Api\Withdraw\WithdrawController;
use App\Http\Controllers\Api\Affiliate\AffiliateController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Auth\VerificationCodeController;
use App\Http\Controllers\Api\CreateTron\CReateTRonController;
use App\Http\Controllers\Api\UserPlan\AffiliateAfterSubscribe;

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
                Route::post('me', [RegisterController::class, 'me']);

    Route::get('deposit',[DepositController::class,'deposit']);
    Route::get('check-deposit',[DepositController::class,'checkDeposit']);
    // withdraw
    Route::post('create-withdraw',[WithdrawController::class,'store']);
    Route::get('withdraw',[WithdrawController::class,'withdraw']);

    //kyc
    Route::get('kyc', [KycController::class, 'index']);
    // ////////////////////Affiliate ////////////////
    Route::get('Affiliate',[AffiliateController::class,'getByParent']);
    Route::post('Affiliate',[AffiliateController::class,'index']);
    Route::post('active-affiliate',[AffiliateController::class,'activeAffiliate']);
    // ////////////////////End Affiliate ////////////////

    Route::get('userSubscribe',[UserPlanController::class,'index']);
    Route::post('userSubscribe',[UserPlanController::class,'store']);
    Route::post('affiliate-after-subscribe',[AffiliateAfterSubscribe::class,'activeParent']);

    });

    Route::post('received-tron',[CReateTRonController::class,'store']);
    Route::get('received-tron',[CReateTRonController::class,'store']);

////

});

require __DIR__.'/admin.php';
