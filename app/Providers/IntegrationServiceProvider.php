<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\LargeLanguageModel;
use App\Contracts\SearchEngine;
use App\Managers\LargeLanguageModelManager;
use App\Managers\SearchEngineManager;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class IntegrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SearchEngineManager::class, fn ($app) => new SearchEngineManager($app));
        $this->app->singleton(SearchEngine::class, fn (Container $app) => $app->make(SearchEngineManager::class)->driver());

        $this->app->singleton(LargeLanguageModelManager::class, fn ($app) => new LargeLanguageModelManager($app));
        $this->app->singleton(LargeLanguageModel::class, fn (Container $app) => $app->make(LargeLanguageModelManager::class)->driver());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
