<?php

declare(strict_types=1);

namespace App\Managers;

use App\Support\SearchEngine\Drivers\DuckDuckGo;
use App\Support\SearchEngine\Drivers\Google;
use Illuminate\Support\Manager;

class SearchEngineManager extends Manager
{
    public function getDefaultDriver()
    {
        return config('integration.search_engine.default', 'google'); // @phpstan-ignore-line
    }

    public function createGoogleDriver(): Google
    {
        /** @var string */
        $apiKey = $this->config->get('services.serpapi.key');

        return new Google($apiKey);
    }

    public function createDuckDuckGoDriver(): DuckDuckGo
    {
        /** @var string */
        $apiKey = $this->config->get('services.serpapi.key');

        return new DuckDuckGo($apiKey);
    }
}
