<?php

namespace App\Services\TestGeneration\Strategies\Contracts;

interface TestTextSupplyingStrategy
{
    public function getText(string $language, int $userId, ?string $genre): ?string;
}
