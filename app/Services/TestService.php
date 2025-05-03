<?php

namespace App\Services;

use App\Models\TestText;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TestService
{
    public function getTestText(int $userId, string $language, ?string $genre = null): string
    {
        $filePath = "uploads/test_{$userId}_{$language}.txt";

        if (Storage::disk('public')->exists($filePath)) {
            if (Storage::disk('public')->lastModified($filePath) < now()->subMinute()->timestamp) {
                Storage::disk('public')->delete($filePath);
            } else {
                return Storage::disk('public')->get($filePath);
            }
        }

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
            } catch (Exception $e) {
                logger()->error($e->getMessage());
            }
        }

        $query = TestText::where('language', $language);

        if ($genre) {
            $query->where('genre', $genre);
        }

        $text = $query->inRandomOrder()->first();

        return $text ? $text->text : 'No text available for the selected language and genre.';
    }
}
