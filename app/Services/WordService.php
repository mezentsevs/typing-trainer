<?php

namespace App\Services;

use App\Services\WordGeneration\WordGenerationOrchestrator;
use Random\RandomException;

class WordService
{
    public function __construct(protected WordGenerationOrchestrator $wordGenerationOrchestrator)
    {
    }

    /**
     * @throws RandomException
     */
    public function generateWord(string $language, array $availableChars, array $newChars): string
    {
        return $this->wordGenerationOrchestrator->generate($language, $availableChars, $newChars);
    }
}
