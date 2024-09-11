<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\ClientRepositoryInterface;
use App\Infrastructure\Repositories\EloquentClientRepository;
use App\Domain\Repositories\ProjectRepositoryInterface;
use App\Infrastructure\Repositories\EloquentProjectRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind the ClientRepositoryInterface to EloquentClientRepository
        $this->app->bind(ClientRepositoryInterface::class, EloquentClientRepository::class);

        // Bind the ProjectRepositoryInterface to EloquentProjectRepository
        $this->app->bind(ProjectRepositoryInterface::class, EloquentProjectRepository::class);
    }

    public function boot()
    {
        //
    }
}
