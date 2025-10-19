<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Blogs\BlogsController;
use App\Http\Controllers\Admin\Wallet\WalletController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Service\ServiceController;

Route::prefix('admin/v1')->group(function () {
    

    Route::apiResource('users', UserController::class)->names('user');
    Route::apiResource('services', ServiceController::class)->names('service');
    Route::apiResource('blogs', BlogsController::class)->names('blogs');
    Route::apiResource('wallets', WalletController::class)->names('wallet');
});
