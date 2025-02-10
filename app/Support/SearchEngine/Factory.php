<?php

declare(strict_types=1);

namespace App\Support\SearchEngine;

use App\Contracts\SearchEngine;
use App\Managers\SearchEngineManager;
use App\Models\User;

class Factory
{
    public static function make(): SearchEngine
    {
        return resolve(SearchEngine::class);
    }

    public static function fromUser(User $user): SearchEngine
    {
        /** @var SearchEngineManager */
        $manager = resolve(SearchEngineManager::class);

        /** @var SearchEngine */
        $engine = $manager->driver($user->search_engine);

        return $engine;
    }
}
