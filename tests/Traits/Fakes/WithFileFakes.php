<?php

namespace Tests\Traits\Fakes;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Traits\Constants\WithFileConstants;

trait WithFileFakes
{
    use WithFileConstants;

    protected function fakeUploadedFile(): UploadedFile
    {
        Storage::fake('public');

        return UploadedFile::fake()->createWithContent(
            self::FILE_NAME,
            self::FILE_CONTENT,
        );
    }
}
