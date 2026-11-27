<?php

namespace App\Services\Word;

use App\Services\Word\WordGeneration\WordGenerationOrchestrator;

class WordService
{
    public function __construct(private WordGenerationOrchestrator $wordGenerationOrchestrator)
    {
    }

    public function generateWord(string $language, array $availableChars, array $newChars): string
    {
        return $this->wordGenerationOrchestrator->generate($language, $availableChars, $newChars);
    }
}
