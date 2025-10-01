<?php

namespace App\Services\TestGeneration\Strategies;

use App\Enums\AiType;

class TestTextGeneratingLocalAiStrategy extends TestTextGeneratingAbstractAiStrategy
{
    protected function getAiType(): AiType
    {
        return AiType::Local;
    }
}
