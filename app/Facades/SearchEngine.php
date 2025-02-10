<?php

declare(strict_types=1);

namespace App\Facades;

use App\Contracts\SearchEngine as SearchEngineContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array<string,mixed> search(string $query)
 *
 * @see SearchEngineContract
 */
class SearchEngine extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SearchEngineContract::class;
    }
}
