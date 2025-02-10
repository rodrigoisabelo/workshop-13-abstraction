<?php

declare(strict_types=1);

namespace App\Support\Document\Parsers;

use App\Contracts\DocumentParser;
use League\HTMLToMarkdown\HtmlConverter;
use League\HTMLToMarkdown\HtmlConverterInterface;

class HtmlParser implements DocumentParser
{
    protected HtmlConverterInterface $converter;

    public function __construct()
    {
        $this->converter = new HtmlConverter();
    }

    public function parse(string $content): string
    {
        return $this->converter->convert($content);
    }
}
