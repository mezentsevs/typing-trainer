<?php

namespace App\Dtos\Test;

use App\Dtos\BaseDto;

class TestRetrieveDto extends BaseDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $language,
        public readonly ?string $genre,
    ) {
    }
}
