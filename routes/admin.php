<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtAdminMiddleware;
use App\Http\Controllers\Admin\ads\adsController;
use App\Http\Controllers\Admin\Rank\RankController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Blogs\BlogsController;
use App\Http\Controllers\Admin\Wallet\WalletController;
use App\Http\Controllers\Admin\Deposit\DepositController;
use App\Http\Controllers\Admin\Partner\PartnerController;
use App\Http\Controllers\Admin\Service\ServiceController;
use App\Http\Controllers\Admin\UserKyc\UserKycController;
use App\Http\Controllers\Admin\UserPlan\UserPlanController;
use App\Http\Controllers\Admin\UserRank\UserRankController;
use App\Http\Controllers\Admin\Withdraw\WithdrawController;
use App\Http\Controllers\Admin\UserTransaction\UserTransactionController;

Route::prefix('admin/v1')->middleware(JwtAdminMiddleware::class)->group(function () {
    
    Route::post('login', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'login']);
    Route::post('me', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'me']);
//////////////////////
    Route::apiResource('users', UserController::class)->names('user');
    Route::apiResource('services', ServiceController::class)->names('service');
    Route::apiResource('blogs', BlogsController::class)->names('blogs');
    Route::apiResource('wallets', WalletController::class)->names('wallet');
    Route::apiResource('ads', adsController::class)->names('ads');
    // Route::apiResource('ranks', RankController::class)->names('rank');
    Route::apiResource('partners', PartnerController::class)->names('partner');
    Route::apiResource('deposits', DepositController::class)->names('deposit');
    Route::apiResource('withdraws', WithdrawController::class)->names('withdraw');
    Route::apiResource('user_kycs', UserKycController::class)->names('user_kyc');
    Route::apiResource('ranks', RankController::class)->names('rank');
    Route::apiResource('user_ranks', UserRankController::class)->names('user_rank');
    Route::apiResource('user_plans', UserPlanController::class)->names('user_plan');
    Route::apiResource('user_transactions', UserTransactionController::class)->names('user_transaction');
});

 

Route::prefix('v1')->group(function () {
 

});
