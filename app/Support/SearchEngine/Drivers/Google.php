<?php

declare(strict_types=1);

namespace App\Support\SearchEngine\Drivers;

use App\Contracts\SearchEngine;
use Illuminate\Support\Facades\Http;

class Google implements SearchEngine
{
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function search(string $query): array
    {
        $response = Http::baseUrl($this->getBaseUrl())
            ->acceptJson()
            ->get('/search', [
                'q' => $query,
                'api_key' => $this->apiKey,
                'engine' => 'google',
            ]);

        return $response->json(); // @phpstan-ignore-line
    }

    public function getBaseUrl(): string
    {
        return config('services.serpapi.base_url'); // @phpstan-ignore-line
    }
}
