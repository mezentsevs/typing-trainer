<?php

namespace Tests\Traits\Assertions;

use PHPUnit\Framework\Assert;
use Tests\Traits\Constants\WithCharacterConstants;

trait WithCharacterAssertions
{
    use WithCharacterConstants;

    protected function assertSingleCharacterString(string $char): void
    {
        Assert::assertIsString($char);
        Assert::assertEquals(
            self::EXPECTED_SINGLE_CHAR_LENGTH,
            mb_strlen($char),
            "Character '{$char}' must be exactly one character long.",
        );
    }

    protected function assertArrayOfSingleCharacterStrings(array $characters): void
    {
        Assert::assertIsArray($characters);
        Assert::assertNotEmpty($characters);

        foreach ($characters as $char) {
            $this->assertSingleCharacterString($char);
        }
    }

    protected function assertUniqueCharacters(array $characters, string $message = 'Characters should be unique.'): void
    {
        $uniqueCharacters = array_unique($characters);

        Assert::assertCount(
            count($characters),
            $uniqueCharacters,
            $message,
        );
    }
}
