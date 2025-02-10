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
        /**
         * We will register first the Search Engine Manager to have only 1 manager instance across the application.
         * We will use this singleton to create a search engine instance.
         */
        $this->app->singleton(SearchEngineManager::class, fn ($app) => new SearchEngineManager($app));

        /**
         * We will create a search engine instance based on system default configuration.
         * By using the search engine manager we instantiated above, we can easily switch between search engine drivers
         * without creating a new instance of the manager.
         */
        $this->app->singleton(SearchEngine::class, fn (Container $app) => $app->make(SearchEngineManager::class)->driver());

        /**
         * We will register the Large Language Model Manager to have only 1 manager instance across the application.
         * We will use this singleton to create a large language model instance.
         */
        $this->app->singleton(LargeLanguageModelManager::class, fn ($app) => new LargeLanguageModelManager($app));

        /**
         * We will create a large language model instance based on system default configuration.
         * By using the large language model manager we instantiated above, we can easily switch between large language model drivers
         * without creating a new instance of the manager.
         */
        $this->app->singleton(LargeLanguageModel::class, fn (Container $app) => $app->make(LargeLanguageModelManager::class)->driver());
    }
}
