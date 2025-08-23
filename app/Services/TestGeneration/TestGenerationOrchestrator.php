<?php

namespace App\Services\TestGeneration;

use App\Services\TestGeneration\Strategies\Contracts\TestTextSupplyingStrategy;

class TestGenerationOrchestrator
{
    /**
     * @param TestTextSupplyingStrategy[] $testTextSupplyingStrategies
     */
    public function __construct(protected array $testTextSupplyingStrategies)
    {
    }

    public function getText(string $language, int $userId, ?string $genre): string
    {
        foreach ($this->testTextSupplyingStrategies as $strategy) {
            $text = $strategy->getText($language, $userId, $genre);
            if ($text !== null) {
                return $text;
            }
        }

        return 'No text available for the selected language and genre.';
    }
}
