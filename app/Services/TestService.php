<?php

namespace App\Services;

use App\Services\TestGeneration\TestGenerationOrchestrator;

class TestService
{
    public function __construct(protected TestGenerationOrchestrator $testGenerationOrchestrator)
    {
    }

    public function getText(string $language, int $userId, ?string $genre = null): string
    {
        return $this->testGenerationOrchestrator->getText($language, $userId, $genre);
    }
}
