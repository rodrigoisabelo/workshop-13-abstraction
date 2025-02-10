<?php

declare(strict_types=1);

namespace App\Contracts;

interface SearchEngine
{
    /**
     * Perform a search.
     *
     * @param string $query
     * @return array<string,mixed>
     */
    public function search(string $query): array;
}
