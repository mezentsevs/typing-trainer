<?php

namespace App\Services\TestGeneration\Strategies\Contracts;

interface TestRetrieveStrategy
{
    public function retrieve(int $userId, string $language, ?string $genre): ?string;
}
