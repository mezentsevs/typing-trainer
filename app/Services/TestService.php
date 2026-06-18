<?php

namespace App\Services;

use App\Dtos\TestRetrieveDto;
use App\Services\TestGeneration\TestGenerationOrchestrator;

class TestService
{
    public function __construct(protected TestGenerationOrchestrator $testGenerationOrchestrator)
    {
    }

    public function retrieve(TestRetrieveDto $dto): string
    {
        return $this->testGenerationOrchestrator->retrieve(
            $dto->userId,
            $dto->language,
            $dto->genre,
        );
    }
}
