<?php

declare(strict_types=1);

use App\Http\Controllers\ChatCompletionController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', fn (Request $request) => $request->user());

Route::middleware(['auth:sanctum'])
    ->name('api.')
    ->group(function (): void {
        Route::get('search-singleton', [SearchController::class, 'fromSingleton'])->name('search.singleton');
        Route::get('search-factory', [SearchController::class, 'fromFactory'])->name('search.factory');
        Route::get('search-factory-user', [SearchController::class, 'fromFactoryUser'])->name('search.factory.user');

        Route::post('/chat/completions/singleton', [ChatCompletionController::class, 'fromSingleton'])->name('chat.completions.singleton');
        Route::post('/chat/completions/factory', [ChatCompletionController::class, 'fromFactory'])->name('chat.completions.factory');
        Route::post('/chat/completions/factory-user', [ChatCompletionController::class, 'fromFactoryUser'])->name('chat.completions.factory.user');
    });
