<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NewsApiService;
use App\Http\Controllers\API\NewsController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(NewsApiService::class, function ($app) {
            return new NewsApiService(config('e056ce2e987c4986a3bb905059444cd4ph'));
        });
    
        $this->app->make(NewsController::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}