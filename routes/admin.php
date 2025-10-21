<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Withdraw\WithdrawController;
use App\Http\Controllers\Admin\ads\adsController;
use App\Http\Controllers\Admin\Rank\RankController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Blogs\BlogsController;
use App\Http\Controllers\Admin\Wallet\WalletController;
use App\Http\Controllers\Admin\Deposit\DepositController;
use App\Http\Controllers\Admin\Service\ServiceController;

Route::prefix('admin/v1')->group(function () {
    
//////////////////////
    Route::apiResource('users', UserController::class)->names('user');
    Route::apiResource('services', ServiceController::class)->names('service');
    Route::apiResource('blogs', BlogsController::class)->names('blogs');
    Route::apiResource('wallets', WalletController::class)->names('wallet');
    Route::apiResource('ads', adsController::class)->names('ads');
    Route::apiResource('ranks', RankController::class)->names('rank');
 
});

 

Route::prefix('v1')->group(function () {
    Route::apiResource('deposits', DepositController::class)->names('deposit');
    Route::apiResource('withdraws', WithdrawController::class)->names('withdraw');
});
