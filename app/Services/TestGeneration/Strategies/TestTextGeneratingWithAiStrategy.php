<?php

namespace App\Services\TestGeneration\Strategies;

use App\Helpers\StringHelper;
use App\Services\TestGeneration\Strategies\Contracts\TestTextSupplyingStrategy;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestTextGeneratingWithAiStrategy implements TestTextSupplyingStrategy
{
    public function getText(string $language, int $userId, ?string $genre): ?string
    {
        if (!config('services.ai_text_generation_api.key') || !$genre) {
            return null;
        }

        try {
            $prompt = __(config('services.ai_text_generation_api.prompt_template'), [
                'language' => $language,
                'genre' => $genre,
            ]);

            $requestPromptKey = config('services.ai_text_generation_api.request_prompt_key');
            $responseTextKey = config('services.ai_text_generation_api.response_text_key');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.ai_text_generation_api.key'),
            ])->post(config('services.ai_text_generation_api.url'), [
                $requestPromptKey => $prompt,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                return isset($responseData[$responseTextKey]) ? StringHelper::sanitize($responseData[$responseTextKey]) : null;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return null;
    }
}
