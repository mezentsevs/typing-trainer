<?php

namespace App\Services;

use App\Models\TestText;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TestService
{
    public function getTestText(string $language, ?string $genre = null, int $userId): string
    {
        if (config('services.grok.key') && $genre) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('services.grok.key'),
                ])->post('https://api.x.ai/v1/generate', [
                    'prompt' => "Generate a 500-word text in $language for typing practice in the $genre genre.",
                ]);

                if ($response->successful()) {
                    return $response->json()['text'];
                }
            } catch (\Exception $e) {
                // Fallback to database text
            }
        }

        $filePath = "uploads/test_{$userId}_{$language}.txt";
        $userFile = Storage::disk('public')->exists($filePath)
            ? Storage::disk('public')->get($filePath)
            : null;

        if ($userFile) {
            return $userFile;
        }

        $query = TestText::where('language', $language);
        if ($genre) {
            $query->where('genre', $genre);
        }
        $text = $query->inRandomOrder()->first();

        return $text ? $text->text : 'No text available for the selected language and genre.';
    }
}
