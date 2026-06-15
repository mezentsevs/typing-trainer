<?php

namespace App\Services;

use App\Services\TestGeneration\TestGenerationOrchestrator;

class TestService
{
    public function __construct(protected TestGenerationOrchestrator $testGenerationOrchestrator)
    {
    }

    public function getText(int $userId, string $language, ?string $genre = null): string
    {
        return $this->testGenerationOrchestrator->getText($userId, $language, $genre);
    }
}
