<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * registrar serviços.
     */
    public function register(): void
    {
        // Repositories
        // $this->app->bind(UserRepository::class, function ($app) {
        //     return new UserRepository();
        // });

        // Services
        // $this->app->bind(UserService::class, function ($app) {
        //     return new UserService(
        //         $app->make(UserRepository::class)
        //     );
        // });
    }

    /**
     * bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}