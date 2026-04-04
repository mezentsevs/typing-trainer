<?php

namespace Tests\Traits\Constants;

use App\Traits\Constants\WithFileConstants as WithAppFileConstants;

trait WithFileConstants
{
    use WithAppFileConstants;

    protected const int FILE_SIZE_KB = 1;
    protected const string FILE_MIME_TYPE = 'text/plain';
    protected const string FILE_NAME = 'test.txt';
    protected const string FILE_CONTENT = 'Test file content';

    protected const int INVALID_EXCEEDED_FILE_SIZE_KB = 4;
    protected const string INVALID_NOT_SUPPORTED_FILE_MIME_TYPE = 'image/jpeg';
    protected const string INVALID_FILE_NAME = 'test.jpeg';
    protected const string INVALID_STRING_FILE = 'invalidStringFile';
}
