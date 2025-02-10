<?php

declare(strict_types=1);

use App\Support\LargeLanguageModel\Drivers\Anthropic;
use App\Support\LargeLanguageModel\Drivers\OpenAI;
use Illuminate\Support\Facades\Http;

function makeFakeResponse(): array
{
    return [
        "id" => "chatcmpl-123",
        "object" => "chat.completion",
        "created" => 1677652288,
        "model" => "gpt-4o-mini",
        "system_fingerprint" => "fp_44709d6fcb",
        "choices" => [
            [
                "index" => 0,
                "message" => [
                    "role" => "assistant",
                    "content" => "\n\nHello there, how may I assist you today?",
                ],
                "logprobs" => null,
                "finish_reason" => "stop",
            ],
        ],
        "service_tier" => "default",
        "usage" => [
            "prompt_tokens" => 9,
            "completion_tokens" => 12,
            "total_tokens" => 21,
            "completion_tokens_details" => [
                "reasoning_tokens" => 0,
                "accepted_prediction_tokens" => 0,
                "rejected_prediction_tokens" => 0,
            ],
        ],
    ];
}

it('can generate ai text from singleton', function (): void {
    authenticate();

    $query = "What is Singleton";
    $fakeResponse = makeFakeResponse();

    Http::fake([
        config('services.openai.base_url') . '/chat/completions' => Http::response($fakeResponse, 200),
    ]);

    $response = $this->postJson(route('api.chat.completions.singleton', [
        'model' => 'gpt-4o-mini',
        'messages' => [
            [
                'role' => 'user',
                'content' => $query,
            ]
        ],
        'max_tokens' => 2048,
        'temperature' => 1,
    ]));

    $response->assertOk();

    expect($response->json())->toBe([
        'data' => $fakeResponse,
        'engine' => OpenAI::class,
    ]);
});

it('can generate ai text from factory', function (): void {
    authenticate();

    $query = "What is Factory?";
    $fakeResponse = makeFakeResponse();

    Http::fake([
        config('services.openai.base_url') . '/chat/completions' => Http::response($fakeResponse, 200),
    ]);

    $response = $this->postJson(route('api.chat.completions.factory', [
        'model' => 'gpt-4o-mini',
        'messages' => [
            [
                'role' => 'user',
                'content' => $query,
            ]
        ],
        'max_tokens' => 2048,
        'temperature' => 1,
    ]));

    $response->assertOk();

    expect($response->json())->toBe([
        'data' => $fakeResponse,
        'engine' => OpenAI::class,
    ]);
});

it('can generate ai text from factory user', function (): void {
    $user = authenticate();

    $user->update([
        'large_language_model' => 'anthropic',
    ]);

    $query = "What is Singleton";
    $fakeResponse = makeFakeResponse();

    Http::fake([
        config('services.anthropic.base_url') . '/messages' => Http::response($fakeResponse, 200),
    ]);

    $response = $this->postJson(route('api.chat.completions.factory.user', [
        'model' => 'gpt-4o-mini',
        'messages' => [
            [
                'role' => 'user',
                'content' => $query,
            ]
        ],
        'max_tokens' => 2048,
        'temperature' => 1,
    ]));

    $response->assertOk();

    expect($response->json())->toBe([
        'data' => $fakeResponse,
        'engine' => Anthropic::class,
    ]);
});
