<?php

namespace App\Services\Test;

use App\Dtos\Test\TestRetrieveDto;
use App\Dtos\Test\TestSaveResultDto;
use App\Dtos\Test\TestUploadDto;
use App\Models\TestResult;
use App\Services\Test\TestGeneration\TestGenerationOrchestrator;
use App\Traits\HasDtoMapping;

class TestService
{
    use HasDtoMapping;

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
            "test_{$dto->userId}_{$dto->language}.txt",
            'public',
        );
    }

    public function saveResult(TestSaveResultDto $dto): TestResult
    {
        return TestResult::create(static::mapDtoToAttributes($dto));
    }
}
