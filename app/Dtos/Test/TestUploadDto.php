<?php

namespace App\Dtos\Test;

use App\Dtos\BaseDto;
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
