<?php

declare(strict_types=1);

namespace App\Support\LargeLanguageModel;

use App\Contracts\LargeLanguageModel;
use App\Managers\LargeLanguageModelManager;
use App\Models\User;

class Factory
{
    public static function make(): LargeLanguageModel
    {
        return resolve(LargeLanguageModel::class);
    }

    public static function fromUser(User $user): LargeLanguageModel
    {
        /** @var LargeLanguageModelManager */
        $manager = resolve(LargeLanguageModelManager::class);

        /** @var LargeLanguageModel */
        $engine = $manager->driver($user->large_language_model);

        return $engine;
    }
}
