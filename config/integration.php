<?php

declare(strict_types=1);

return [
    'search_engine' => [
        'default' => env('SEARCH_ENGINE', 'google'),
    ],

    'large_language_model' => [
        'default' => env('LARGE_LANGUAGE_MODEL', 'openai'),
    ]
];
