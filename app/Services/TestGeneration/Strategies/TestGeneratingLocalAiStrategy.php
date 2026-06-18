<?php

namespace App\Services\TestGeneration\Strategies;

use App\Enums\AiType;

class TestGeneratingLocalAiStrategy extends TestGeneratingAbstractAiStrategy
{
    protected function getAiType(): AiType
    {
        return AiType::Local;
    }
}
