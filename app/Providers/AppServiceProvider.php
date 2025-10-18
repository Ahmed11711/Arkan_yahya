<?php

namespace App\Providers;

use App\Repositories\blogs\blogsRepositoryInterface;
use App\Repositories\blogs\blogsRepository;

use App\Repositories\Blog\BlogRepositoryInterface;
use App\Repositories\Blog\BlogRepository;

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
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->bind(blogsRepositoryInterface::class, blogsRepository::class);
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
               Model::unguard();
    }
}
