<?php

namespace App\Services\Test\TestGeneration\Strategies;

use App\Helpers\StringHelper;
use App\Services\Test\TestGeneration\Strategies\Contracts\TestRetrieveStrategy;
use Illuminate\Support\Facades\Storage;

class TestRetrieveFileStrategy implements TestRetrieveStrategy
{
    public function retrieve(int $userId, string $language, ?string $genre): ?string
    {
        $disk = Storage::disk('public');
        $filePath = "uploads/test_{$userId}_{$language}.txt";

        if ($disk->exists($filePath)) {
            if ($disk->lastModified($filePath) < now()->subMinute()->timestamp) {
                $disk->delete($filePath);
            } else {
                return StringHelper::normalize($disk->get($filePath));
            }
        }

        return null;
    }
}
