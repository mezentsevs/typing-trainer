<?php

namespace App\Services\TestGeneration\Strategies;

use App\Helpers\StringHelper;
use App\Services\TestGeneration\Strategies\Contracts\TestTextSupplyingStrategy;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestTextGeneratingLocalAiStrategy implements TestTextSupplyingStrategy
{
    public function getText(string $language, int $userId, ?string $genre): ?string
    {
        if (!config('services.ai_text_generation.local.enabled') || !$genre) {
            return null;
        }

        try {
            $prompt = __(config('services.ai_text_generation.prompt_template'), [
                'language' => $language,
                'genre' => $genre,
            ]);

            $requestBody = [
                'model' => config('services.ai_text_generation.local.model'),
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => (int) config('services.ai_text_generation.local.max_tokens'),
                'temperature' => (float) config('services.ai_text_generation.local.temperature'),
                'stream' => (bool) config('services.ai_text_generation.local.stream'),
            ];

            $headers = ['Content-Type' => 'application/json'];

            if (config('services.ai_text_generation.local.key')) {
                $headers['Authorization'] = 'Bearer ' . config('services.ai_text_generation.local.key');
            }

            $response = Http::timeout((int) config('services.ai_text_generation.local.timeout'))
                ->withHeaders($headers)
                ->post(config('services.ai_text_generation.local.url'), $requestBody);

            if ($response->successful()) {
                $responseData = $response->json();
                $generatedText = Arr::get($responseData, 'choices.0.message.content');
                return $generatedText ? StringHelper::sanitize($generatedText) : null;
            } else {
                throw new Exception('Local AI API error with response status: ' . $response->status());
            }
        } catch (Exception $e) {
            Log::warning('Local AI API error: ' . $e->getMessage());
        }

        return null;
    }
}
