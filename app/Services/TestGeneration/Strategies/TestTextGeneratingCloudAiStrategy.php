<?php

namespace App\Services\TestGeneration\Strategies;

use App\Enums\AiType;

class TestTextGeneratingCloudAiStrategy extends TestTextGeneratingAbstractAiStrategy
{
    protected function getAiType(): AiType
    {
        return AiType::Cloud;
    }

    protected function isEnabled(): bool
    {
        $aiType = $this->getAiType()->value;

        return parent::isEnabled() && config("services.ai_text_generation.{$aiType}.key");
    }
}
