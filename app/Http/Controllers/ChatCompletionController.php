<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\LargeLanguageModel;
use App\Support\LargeLanguageModel\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatCompletionController extends Controller
{
    /**
     * This is for use cases when we just need to perform text generation using system default large language model provider.
     *
     * @param Request $request
     * @param LargeLanguageModel $llm
     * @return JsonResponse
     */
    public function fromSingleton(Request $request, LargeLanguageModel $llm): JsonResponse
    {
        $request->validate([
            'model' => ['required', 'string'],
            'messages' => ['required', 'array'],
            'messages.*.content' => ['required', 'string'],
            'messages.*.role' => ['required', 'string', 'in:user,assistant'],
            'max_tokens' => ['sometimes', 'integer'],
            'temperature' => ['sometimes', 'numeric'],
        ]);

        $response = $llm->chat(
            model: $request->string('model')->toString(),
            messages: $request->array('messages'),
            maxTokens: $request->integer('max_tokens'),
            temperature: $request->float('temperature'),
        );

        return response()->json([
            'data' => $response,
            'engine' => get_class($llm),
        ]);
    }

    /**
     * This is for use cases when we need to perform text generation using the factory pattern.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fromFactory(Request $request): JsonResponse
    {
        $request->validate([
            'model' => ['required', 'string'],
            'messages' => ['required', 'array'],
            'messages.*.content' => ['required', 'string'],
            'messages.*.role' => ['required', 'string', 'in:user,assistant'],
            'max_tokens' => ['sometimes', 'integer'],
            'temperature' => ['sometimes', 'numeric'],
        ]);

        /** @var LargeLanguageModel */
        $llm = Factory::make();

        $response = $llm->chat(
            model: $request->string('model')->toString(),
            messages: $request->array('messages'),
            maxTokens: $request->integer('max_tokens'),
            temperature: $request->float('temperature'),
        );

        return response()->json([
            'data' => $response,
            'engine' => get_class($llm),
        ]);
    }

    /**
     * This is for use cases when we need to perform text generation using the factory pattern with user context.
     * By using the factory, based on user settings, we can provide different large language model providers.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fromFactoryUser(Request $request)
    {
        $request->validate([
            'model' => ['required', 'string'],
            'messages' => ['required', 'array'],
            'messages.*.content' => ['required', 'string'],
            'messages.*.role' => ['required', 'string', 'in:user,assistant'],
            'max_tokens' => ['sometimes', 'integer'],
            'temperature' => ['sometimes', 'numeric'],
        ]);

        /** @var LargeLanguageModel */
        $llm = Factory::fromUser($request->user()); // @phpstan-ignore-line

        $response = $llm->chat(
            model: $request->string('model')->toString(),
            messages: $request->array('messages'),
            maxTokens: $request->integer('max_tokens'),
            temperature: $request->float('temperature'),
        );

        return response()->json([
            'data' => $response,
            'engine' => get_class($llm),
        ]);
    }
}
