<?php

namespace App\Services\Test\TestGeneration\Strategies;

use App\Enums\AiType;

class TestRetrieveAiLocalStrategy extends BaseTestRetrieveAiStrategy
{
    protected function getAiType(): AiType
    {
        return AiType::Local;
    }
}
