<?php

namespace App\Providers;

use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Repositories\Wallet\WalletRepository;

use App\Repositories\Service\ServiceRepositoryInterface;
use App\Repositories\Service\ServiceRepository;

use App\Repositories\Blogs\BlogsRepositoryInterface;
use App\Repositories\Blogs\BlogsRepository;
use App\Repositories\Kyc\KycRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Repositories\User\UserRepository;
use App\Repositories\Kyc\KycRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\UserTwoFactor\UserTwoFactorRepository;
use App\Repositories\UserTwoFactor\UserTwoFactorRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {
$this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserTwoFactorRepositoryInterface::class,UserTwoFactorRepository::class);
        $this->app->bind(KycRepositoryInterface::class,KycRepository::class);
          $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
         $this->app->bind(BlogsRepositoryInterface::class, BlogsRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
               Model::unguard();
    }
}
