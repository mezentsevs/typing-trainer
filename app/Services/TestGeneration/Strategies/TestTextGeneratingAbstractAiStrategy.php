<?php

namespace App\Services\TestGeneration\Strategies;

use App\Enums\AiType;
use App\Helpers\StringHelper;
use App\Services\TestGeneration\Strategies\Contracts\TestTextSupplyingStrategy;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class TestTextGeneratingAbstractAiStrategy implements TestTextSupplyingStrategy
{
    private string $language;
    private ?string $genre;
    private string $aiType;
    private string $strategyName;

    abstract protected function getAiType(): AiType;

    public function getText(string $language, int $userId, ?string $genre): ?string
    {
        $this->initializeStrategy($language, $genre);

        if (!$this->shouldProceed()) {
            return null;
        }

        try {
            return $this->attemptTextGeneration();
        } catch (Exception $e) {
            $this->handleException($e);
        }

        return null;
    }

    protected function isEnabled(): bool
    {
        return (bool) config("services.ai_text_generation.{$this->aiType}.enabled");
    }

    private function initializeStrategy(string $language, ?string $genre): void
    {
        $this->language = $language;
        $this->genre = $genre;
        $this->aiType = $this->getAiType()->value;
        $this->strategyName = ucfirst($this->aiType) . ' AI';
    }

    private function shouldProceed(): bool
    {
        return $this->isEnabled() && !empty($this->genre);
    }

    private function attemptTextGeneration(): ?string
    {
        $requestHeaders = $this->buildRequestHeaders();
        $requestBody = $this->buildRequestBody($this->buildPrompt());

        $response = $this->sendHttpRequest($requestHeaders, $requestBody);

        return $this->processResponse($response);
    }

    private function buildRequestHeaders(): array
    {
        $headers = ['Content-Type' => 'application/json'];
        $apiKey = config("services.ai_text_generation.{$this->aiType}.key");

        if ($apiKey) {
            $headers['Authorization'] = 'Bearer ' . $apiKey;
        }

        return $headers;
    }

    private function buildPrompt(): string
    {
        return __(config('services.ai_text_generation.prompt_template'), [
            'language' => $this->language,
            'genre' => $this->genre,
        ]);
    }

    private function buildRequestBody(string $prompt): array
    {
        return [
            'model' => config("services.ai_text_generation.{$this->aiType}.model"),
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => (int) config("services.ai_text_generation.{$this->aiType}.max_tokens"),
            'temperature' => (float) config("services.ai_text_generation.{$this->aiType}.temperature"),
            'stream' => (bool) config("services.ai_text_generation.{$this->aiType}.stream"),
        ];
    }

    private function sendHttpRequest(array $requestHeaders, array $requestBody): Response
    {
        return Http::timeout((int) config("services.ai_text_generation.{$this->aiType}.timeout"))
            ->withHeaders($requestHeaders)
            ->post(config("services.ai_text_generation.{$this->aiType}.url"), $requestBody);
    }

    private function processResponse(Response $response): ?string
    {
        if (!$response->successful()) {
            throw new Exception("{$this->strategyName} API error with response status: " . $response->status());
        }

        $text = Arr::get($response->json(), 'choices.0.message.content');

        return $text ? StringHelper::sanitize($text) : null;
    }

    private function handleException(Exception $e): void
    {
        $this->logError($e->getMessage());
    }

    private function logError(string $message): void
    {
        Log::error("{$this->strategyName} API error: " . $message);
    }
}
