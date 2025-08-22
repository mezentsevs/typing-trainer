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
    public function generateWord(array $availableChars, array $newChars, string $language): string
    {
        return $this->wordGenerationOrchestrator->generate($availableChars, $newChars, $language);
    }
}
