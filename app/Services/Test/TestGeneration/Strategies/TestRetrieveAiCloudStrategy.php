<?php

namespace App\Services\Test\TestGeneration\Strategies;

use App\Enums\AiType;

class TestRetrieveAiCloudStrategy extends BaseTestRetrieveAiStrategy
{
    protected function getAiType(): AiType
    {
        return AiType::Cloud;
    }

    protected function isEnabled(): bool
    {
        return parent::isEnabled() && config("{$this->aiConfigPath}.key");
    }
}
