<?php

declare(strict_types=1);

namespace App\Support\SearchEngine\Drivers;

use App\Contracts\SearchEngine;
use Illuminate\Support\Facades\Http;

class DuckDuckGo implements SearchEngine
{
    private string $apiKey;

    public function __construct(string $apikey)
    {
        $this->apiKey = $apikey;
    }

    public function search(string $query): array
    {
        $response = Http::baseUrl($this->getBaseUrl())
            ->acceptJson()
            ->get('/search', [
                'q' => $query,
                'api_key' => $this->apiKey,
                'engine' => 'duckduckgo',
            ]);

        return $response->json(); // @phpstan-ignore-line
    }

    protected function getBaseUrl(): string
    {
        return config('services.serpapi.base_url'); // @phpstan-ignore-line
    }
}
