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
     * Perform search from system default's search engine.
     *
     * @param Request $request
     * @param SearchEngine $engine
     * @return JsonResponse
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

    /**
     * Perform search using the factory pattern. This is still based on the system default search engine.
     *
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * Perform search using the factory pattern. This is based on the user's search engine preference.
     *
     * @param Request $request
     * @return JsonResponse
     */
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
