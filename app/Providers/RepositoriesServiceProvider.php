<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\DashboardRepositoryInterface;
use App\Repositories\Interfaces\FoodRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\UserActivityLogRepositoryInterface;
use App\Repositories\DashboardRepository;
use App\Repositories\FoodRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\UserActivityLogRepository;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);
        $this->app->bind(FoodRepositoryInterface::class, FoodRepository::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(UserActivityLogRepositoryInterface::class, UserActivityLogRepository::class);
    }
}
