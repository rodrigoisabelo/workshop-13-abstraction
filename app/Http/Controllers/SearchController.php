<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\SearchEngine;
use App\Support\SearchEngine\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function fromSingleton(Request $request, SearchEngine $engine): JsonResponse
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        return response()->json([
            'data' => $engine->search($request->string('query')->toString()),
            'engine' => get_class($engine),
        ]);
    }

    public function fromFactory(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        /** @var SearchEngine */
        $engine = Factory::make();

        return response()->json([
            'data' => $engine->search($request->string('query')->toString()),
            'engine' => get_class($engine),
        ]);
    }

    public function fromFactoryUser(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        /** @var SearchEngine */
        $engine = Factory::fromUser($request->user()); // @phpstan-ignore-line

        return response()->json([
            'data' => $engine->search($request->string('query')->toString()),
            'engine' => get_class($engine),
        ]);
    }
}
