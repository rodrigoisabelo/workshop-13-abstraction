<?php

declare(strict_types=1);

namespace App\Support\Document;

use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class Parser
{
    public function parse(string $path, string|null $disk = null): string
    {
        $content = Storage::disk($disk)->get($path) ?? '';
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return match($extension) {
            'pdf' => (new Parsers\PdfParser())->parse($content),
            'html' => (new Parsers\HtmlParser())->parse($content),
            default => throw new InvalidArgumentException("Unsupported file type: {$extension}"),
        };
    }
}
