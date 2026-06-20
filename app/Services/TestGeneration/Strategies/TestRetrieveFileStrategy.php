<?php

namespace App\Services\TestGeneration\Strategies;

use App\Helpers\StringHelper;
use App\Services\TestGeneration\Strategies\Contracts\TestRetrieveStrategy;
use Illuminate\Support\Facades\Storage;

class TestRetrieveFileStrategy implements TestRetrieveStrategy
{
    public function retrieve(int $userId, string $language, ?string $genre): ?string
    {
        $filePath = "uploads/test_{$userId}_{$language}.txt";

        if (Storage::disk('public')->exists($filePath)) {
            if (Storage::disk('public')->lastModified($filePath) < now()->subMinute()->timestamp) {
                Storage::disk('public')->delete($filePath);
            } else {
                return StringHelper::normalize(Storage::disk('public')->get($filePath));
            }
        }

        return null;
    }
}
