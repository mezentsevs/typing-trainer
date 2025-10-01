<?php

namespace App\Services\TestGeneration\Strategies;

use App\Helpers\StringHelper;
use App\Services\TestGeneration\Strategies\Contracts\TestTextSupplyingStrategy;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestTextGeneratingCloudAiStrategy implements TestTextSupplyingStrategy
{
    public function getText(string $language, int $userId, ?string $genre): ?string
    {
        if (!config('services.ai_text_generation.cloud.enabled') || !config('services.ai_text_generation.cloud.key') || !$genre) {
            return null;
        }

        try {
            $prompt = __(config('services.ai_text_generation.prompt_template'), [
                'language' => $language,
                'genre' => $genre,
            ]);

            $requestBody = [
                'model' => config('services.ai_text_generation.cloud.model'),
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => (int) config('services.ai_text_generation.cloud.max_tokens'),
                'temperature' => (float) config('services.ai_text_generation.cloud.temperature'),
                'stream' => (bool) config('services.ai_text_generation.cloud.stream'),
            ];

            $headers = ['Content-Type' => 'application/json'];

            if (config('services.ai_text_generation.cloud.key')) {
                $headers['Authorization'] = 'Bearer ' . config('services.ai_text_generation.cloud.key');
            }

            $response = Http::timeout((int) config('services.ai_text_generation.cloud.timeout'))
                ->withHeaders($headers)
                ->post(config('services.ai_text_generation.cloud.url'), $requestBody);

            if ($response->successful()) {
                $responseData = $response->json();
                $generatedText = Arr::get($responseData, 'choices.0.message.content');
                return $generatedText ? StringHelper::sanitize($generatedText) : null;
            } else {
                throw new Exception('Cloud AI API error with response status: ' . $response->status());
            }
        } catch (Exception $e) {
            Log::warning('Cloud AI API error: ' . $e->getMessage());
        }

        return null;
    }
}
