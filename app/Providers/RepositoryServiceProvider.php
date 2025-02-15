<?php

namespace App\Providers;

use App\Interface\ProjectRepositoryInterface;
use App\Interface\UserRepositoryInterface;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
