<?php

namespace App\Dtos;

use Illuminate\Http\UploadedFile;

class TestUploadDto extends BaseDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $language,
        public readonly UploadedFile $file,
    ) {
    }
}
