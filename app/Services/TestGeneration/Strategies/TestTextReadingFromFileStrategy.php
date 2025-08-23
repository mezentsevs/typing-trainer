<?php

namespace App\Services\TestGeneration\Strategies;

use App\Helpers\StringHelper;
use App\Services\TestGeneration\Strategies\Contracts\TestTextSupplyingStrategy;
use Illuminate\Support\Facades\Storage;

class TestTextReadingFromFileStrategy implements TestTextSupplyingStrategy
{
    public function getText(string $language, int $userId, ?string $genre): ?string
    {
        $filePath = "uploads/test_{$userId}_{$language}.txt";

        if (Storage::disk('public')->exists($filePath)) {
            if (Storage::disk('public')->lastModified($filePath) < now()->subMinute()->timestamp) {
                Storage::disk('public')->delete($filePath);
            } else {
                return StringHelper::sanitize(Storage::disk('public')->get($filePath));
            }
        }

        return null;
    }
}
