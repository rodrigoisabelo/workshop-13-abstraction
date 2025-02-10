<?php

declare(strict_types=1);

namespace App\Contracts;

interface LargeLanguageModel
{
    /**
     * Chat with the large language model.
     *
     * @param string $model
     * @param array<array{content:string,role:string,name?:string}> $messages
     * @param int $maxTokens
     * @param float $temperature
     * @return array<string,mixed>
     */
    public function chat(string $model, array $messages = [], int $maxTokens = 2048, float $temperature = 1): array;
}
