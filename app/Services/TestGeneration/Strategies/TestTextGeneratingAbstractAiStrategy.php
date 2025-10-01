<?php

namespace App\Services\TestGeneration\Strategies;

use App\Enums\AiType;
use App\Helpers\StringHelper;
use App\Services\TestGeneration\Strategies\Contracts\TestTextSupplyingStrategy;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class TestTextGeneratingAbstractAiStrategy implements TestTextSupplyingStrategy
{
    abstract protected function getAiType(): AiType;

    public function getText(string $language, int $userId, ?string $genre): ?string
    {
        if (!$this->isEnabled() || !$genre) {
            return null;
        }

        $aiType = $this->getAiType()->value;
        $strategyName = ucfirst($aiType) . ' AI';

        try {
            $prompt = __(config('services.ai_text_generation.prompt_template'), [
                'language' => $language,
                'genre' => $genre,
            ]);

            $requestBody = [
                'model' => config("services.ai_text_generation.{$aiType}.model"),
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => (int) config("services.ai_text_generation.{$aiType}.max_tokens"),
                'temperature' => (float) config("services.ai_text_generation.{$aiType}.temperature"),
                'stream' => (bool) config("services.ai_text_generation.{$aiType}.stream"),
            ];

            $headers = ['Content-Type' => 'application/json'];

            $apiKey = config("services.ai_text_generation.{$aiType}.key");

            if ($apiKey) {
                $headers['Authorization'] = 'Bearer ' . $apiKey;
            }

            $response = Http::timeout((int) config("services.ai_text_generation.{$aiType}.timeout"))
                ->withHeaders($headers)
                ->post(config("services.ai_text_generation.{$aiType}.url"), $requestBody);

            if ($response->successful()) {
                $responseData = $response->json();
                $generatedText = Arr::get($responseData, 'choices.0.message.content');
                return $generatedText ? StringHelper::sanitize($generatedText) : null;
            } else {
                throw new Exception("{$strategyName} API error with response status: " . $response->status());
            }
        } catch (Exception $e) {
            Log::warning("{$strategyName} API error: " . $e->getMessage());
        }

        return null;
    }

    protected function isEnabled(): bool
    {
        $aiType = $this->getAiType()->value;

        return (bool) config("services.ai_text_generation.{$aiType}.enabled");
    }
}
