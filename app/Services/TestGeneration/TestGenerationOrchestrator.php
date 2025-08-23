<?php

namespace App\Services\TestGeneration;

use App\Services\TestGeneration\Strategies\TestTextAiGeneratingStrategy;
use App\Services\TestGeneration\Strategies\TestTextDatabaseRetrievingStrategy;
use App\Services\TestGeneration\Strategies\TestTextFileReadingStrategy;

class TestGenerationOrchestrator
{
    public function __construct(
        protected TestTextFileReadingStrategy $testTextFileReadingStrategy,
        protected TestTextAiGeneratingStrategy $testTextAiGeneratingStrategy,
        protected TestTextDatabaseRetrievingStrategy $testTextDatabaseRetrievingStrategy,
    ) {
    }

    public function getText(string $language, int $userId, ?string $genre): string
    {
        $strategies = [
            $this->testTextFileReadingStrategy,
            $this->testTextAiGeneratingStrategy,
            $this->testTextDatabaseRetrievingStrategy,
        ];

        foreach ($strategies as $strategy) {
            $text = $strategy->getText($language, $userId, $genre);
            if ($text !== null) {
                return $text;
            }
        }

        return 'No text available for the selected language and genre.';
    }
}
