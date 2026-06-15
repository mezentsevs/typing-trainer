<?php

namespace App\Services\TestGeneration\Strategies\Contracts;

interface TestTextSupplyingStrategy
{
    public function getText(int $userId, string $language, ?string $genre): ?string;
}
