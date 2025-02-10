<?php

declare(strict_types=1);

namespace App\Support\Document\Parsers;

use App\Contracts\DocumentParser;
use League\HTMLToMarkdown\HtmlConverter;
use League\HTMLToMarkdown\HtmlConverterInterface;
use Smalot\PdfParser\Parser;

class PdfParser implements DocumentParser
{
    protected HtmlConverterInterface $converter;
    protected Parser $parser;

    public function __construct()
    {
        $this->converter = new HtmlConverter();
        $this->parser = new Parser();
    }

    public function parse(string $content): string
    {
        $pdf = $this->parser->parseContent($content);
        $text = mb_convert_encoding($pdf->getText(), 'UTF-8', 'auto');

        /** @var string */
        $text = iconv('UTF-8', 'UTF-8//IGNORE', $text);

        $content = $this->converter->convert($text);

        return $content;
    }
}
