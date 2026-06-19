<?php

namespace App\Services;

use App\Dtos\TestRetrieveDto;
use App\Dtos\TestUploadDto;
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

    public function upload(TestUploadDto $dto): string
    {
        return $dto->file->storeAs(
            'uploads',
            'test_' . $dto->userId . "_{$dto->language}.txt",
            'public',
        );
    }
}
