<?php

declare(strict_types=1);

namespace App\Contracts;

interface DocumentParser
{
    public function parse(string $content): string;
}
