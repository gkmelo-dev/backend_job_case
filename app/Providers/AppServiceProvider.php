<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\ClientRepositoryInterface;
use App\Infrastructure\Repositories\EloquentClientRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind the ClientRepositoryInterface to EloquentClientRepository
        $this->app->bind(ClientRepositoryInterface::class, EloquentClientRepository::class);
    }

    public function boot()
    {
        //
    }
}
