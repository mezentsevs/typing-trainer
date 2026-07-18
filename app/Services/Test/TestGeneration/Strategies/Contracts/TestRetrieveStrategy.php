<?php

namespace App\Services\Test\TestGeneration\Strategies\Contracts;

interface TestRetrieveStrategy
{
    public function retrieve(int $userId, string $language, ?string $genre): ?string;
}
