<?php

declare(strict_types=1);

use App\Support\SearchEngine\Drivers\DuckDuckGo;
use App\Support\SearchEngine\Drivers\Google;
use Illuminate\Support\Facades\Http;

function makeFakeSearchResuls(): array
{
    return [
        'organic_results' => [
            ['title' => 'Singleton Pattern', 'link' => 'https://en.wikipedia.org/wiki/Singleton_pattern'],
            ['title' => 'Singleton Design Pattern', 'link' => 'https://refactoring.guru/design-patterns/singleton'],
        ]
    ];
}

it('can search from singleton', function (): void {
    authenticate();

    $query = "What is Singleton";
    $fakeSearchResults = makeFakeSearchResuls();

    Http::fake([
        config('services.serpapi.base_url') . '/*' => Http::response($fakeSearchResults, 200),
    ]);

    $response = $this->getJson(route('api.search.singleton', ['query' => $query]));

    $response->assertOk();

    expect($response->json())->toBe([
        'data' => $fakeSearchResults,
        'engine' => Google::class,
    ]);
});

it('can search from factory', function (): void {
    authenticate();

    $query = "What is Singleton";
    $fakeSearchResults = makeFakeSearchResuls();

    Http::fake([
        config('services.serpapi.base_url') . '/*' => Http::response($fakeSearchResults, 200),
    ]);

    $response = $this->getJson(route('api.search.factory', ['query' => $query]));

    $response->assertOk();

    expect($response->json())->toBe([
        'data' => $fakeSearchResults,
        'engine' => Google::class,
    ]);
});

it('can search from factory user', function (): void {
    $user = authenticate();

    $user->update([
        'search_engine' => 'duck_duck_go',
    ]);

    $query = "What is Singleton";
    $fakeSearchResults = makeFakeSearchResuls();

    Http::fake([
        config('services.serpapi.base_url') . '/*' => Http::response($fakeSearchResults, 200),
    ]);

    $response = $this->getJson(route('api.search.factory.user', ['query' => $query]));

    $response->assertOk();

    expect($response->json())->toBe([
        'data' => $fakeSearchResults,
        'engine' => DuckDuckGo::class,
    ]);
});
