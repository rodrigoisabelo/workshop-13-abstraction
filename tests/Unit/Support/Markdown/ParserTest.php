<?php

declare(strict_types=1);

uses(Tests\TestCase::class);

use App\Support\Document\Parser;
use Illuminate\Support\Facades\Storage;

it('can parse pdf', function (): void {
    // Load valid PDF content from a file
    $pdfContent = file_get_contents(base_path('tests/Fixtures/dummy.pdf'));

    // Mock the storage
    Storage::fake('local');
    Storage::disk('local')->put('test.pdf', $pdfContent);

    // Parse the file
    $parser = new Parser();
    $content = $parser->parse('test.pdf', 'local');

    expect($content)->toBe('Dummy PDF file'); // Update expectation based on parser's implementation
});

it('can parse html', function (): void {
    // Load valid HTML content from a file
    $htmlContent = file_get_contents(base_path('tests/Fixtures/dummy.html'));

    // Mock the storage
    Storage::fake('local');
    Storage::disk('local')->put('test.html', $htmlContent);

    // Parse the file
    $parser = new Parser();
    $content = $parser->parse('test.html', 'local');

    expect($content)->toContain('Lorem ipsum dolor sit amet consectetur adipisicing elit.');
});

it('cannot parse unsupported file type', function (): void {
    // Load valid text content from a file
    $textContent = file_get_contents(base_path('tests/Fixtures/dummy.txt'));

    // Mock the storage
    Storage::fake('local');
    Storage::disk('local')->put('test.txt', $textContent);

    // Parse the file
    $parser = new Parser();
    $content = $parser->parse('test.txt', 'local');

    expect($content)->toBeNull();
})->throws(InvalidArgumentException::class);
