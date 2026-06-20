<?php

namespace App\Services;

use App\Dtos\TestRetrieveDto;
use App\Dtos\TestSaveResultDto;
use App\Dtos\TestUploadDto;
use App\Models\TestResult;
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

    public function saveResult(TestSaveResultDto $dto): TestResult
    {
        return TestResult::create([
            'user_id' => $dto->userId,
            'language' => $dto->language,
            'time_seconds' => $dto->timeSeconds,
            'speed_wpm' => $dto->speedWpm,
            'errors' => $dto->errors,
        ]);
    }
}
