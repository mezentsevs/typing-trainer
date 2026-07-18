<?php

namespace App\Services\Test\TestGeneration;

use App\Services\Test\TestGeneration\Strategies\Contracts\TestRetrieveStrategy;

class TestGenerationOrchestrator
{
    /**
     * @param TestRetrieveStrategy[] $strategies
     */
    public function __construct(protected array $strategies)
    {
    }

    public function retrieve(int $userId, string $language, ?string $genre): string
    {
        foreach ($this->strategies as $strategy) {
            $text = $strategy->retrieve($userId, $language, $genre);
            if ($text !== null) {
                return $text;
            }
        }

        return 'No text available for the selected language and genre.';
    }
}
