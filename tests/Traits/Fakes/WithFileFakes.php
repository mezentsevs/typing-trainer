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

    protected function fakeInvalidUploadedFileWithNotSupportedFileMimeType(): UploadedFile
    {
        Storage::fake('public');

        return UploadedFile::fake()->create(
            self::INVALID_FILE_NAME,
            self::FILE_SIZE_KB,
            self::INVALID_NOT_SUPPORTED_FILE_MIME_TYPE,
        );
    }

    protected function fakeInvalidUploadedFileWithExceededFileSize(): UploadedFile
    {
        Storage::fake('public');

        return UploadedFile::fake()->create(
            self::FILE_NAME,
            self::INVALID_EXCEEDED_FILE_SIZE_KB,
            self::FILE_MIME_TYPE,
        );
    }
}
