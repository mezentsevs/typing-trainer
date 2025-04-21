<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TestService
{
    protected $fallbackTexts = [
        'en' => [
            'The quick brown fox jumps over the lazy dog.',
            'A journey of a thousand miles begins with a single step.',
        ],
        'ru' => [
            'Быстрая лиса перепрыгнула через ленивую собаку.',
            'Путешествие в тысячу миль начинается с одного шага.',
        ],
    ];

    public function getTestText(string $language, ?string $genre = null, int $userId): string
    {
        if (env('GROK_API_KEY') && $genre) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('GROK_API_KEY'),
                ])->post('https://api.x.ai/v1/generate', [
                    'prompt' => "Generate a 100-word text in $language for typing practice in the $genre genre.",
                ]);

                if ($response->successful()) {
                    return $response->json()['text'];
                }
            } catch (\Exception $e) {
                // Fallback to local text
            }
        }

        $filePath = "uploads/test_{$userId}_{$language}.txt";
        $userFile = Storage::disk('public')->exists($filePath)
            ? Storage::disk('public')->get($filePath)
            : null;

        return $userFile ?? $this->fallbackTexts[$language][array_rand($this->fallbackTexts[$language])];
    }
}
