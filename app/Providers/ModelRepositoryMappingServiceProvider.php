<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\ModelRepositoryMappingService\ModelRepositoryMappingServiceInterface;
use App\Http\Services\ModelRepositoryMappingService\ModelRepositoryMappingService;

class ModelRepositoryMappingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(ModelRepositoryMappingServiceInterface::class, ModelRepositoryMappingService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
