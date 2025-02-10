<?php

declare(strict_types=1);

namespace App\Support\LargeLanguageModel\Drivers;

use App\Contracts\LargeLanguageModel;
use Illuminate\Support\Facades\Http;

class OpenAI implements LargeLanguageModel
{
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function chat(string $model, array $messages = [], int $maxTokens = 2048, float $temperature = 1): array
    {
        $response = Http::baseUrl($this->getBaseUrl())
            ->withToken($this->apiKey)
            ->acceptJson()
            ->post('/chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'max_tokens' => $maxTokens,
                'temperature' => $temperature,
            ]);

        if ($response->failed()) {
            $response->throw();
        }

        return $response->json(); // @phpstan-ignore-line
    }

    protected function getBaseUrl(): string
    {
        return config('services.openai.base_url'); // @phpstan-ignore-line
    }
}
