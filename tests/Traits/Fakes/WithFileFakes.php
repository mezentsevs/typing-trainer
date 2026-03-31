<?php

namespace Tests\Traits\Fakes;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Traits\Constants\WithFileConstants;

trait WithFileFakes
{
    use WithFileConstants;

    protected function fakeValidUploadedFile(): UploadedFile
    {
        Storage::fake('public');

        return UploadedFile::fake()->createWithContent(
            self::FILE_NAME,
            self::FILE_CONTENT,
        );
    }

    protected function fakeInvalidUploadedFileWithNotSupportedMimeType(): UploadedFile
    {
        Storage::fake('public');

        return UploadedFile::fake()->create(
            self::INVALID_FILE_NAME,
            self::FILE_SIZE_KB,
            self::INVALID_FILE_MIME_TYPE,
        );
    }
}
