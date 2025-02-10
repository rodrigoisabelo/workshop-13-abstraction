<?php

declare(strict_types=1);

namespace App\Managers;

use App\Support\LargeLanguageModel\Drivers\Anthropic;
use App\Support\LargeLanguageModel\Drivers\OpenAI;
use Illuminate\Support\Manager;

class LargeLanguageModelManager extends Manager
{
    public function getDefaultDriver()
    {
        return config('integration.large_language_model.default', 'openai'); // @phpstan-ignore-line
    }

    public function createOpenaiDriver(): OpenAI
    {
        /** @var string */
        $apiKey = $this->config->get('services.openai.key');

        return new OpenAI($apiKey);
    }

    public function createAnthropicDriver(): Anthropic
    {
        /** @var string */
        $apiKey = $this->config->get('services.anthropic.key');

        return new Anthropic($apiKey);
    }
}
