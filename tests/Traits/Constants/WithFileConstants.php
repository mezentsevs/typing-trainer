<?php

namespace Tests\Traits\Constants;

trait WithFileConstants
{
    protected const int MAX_FILE_SIZE_KB = 3;
    protected const string FILE_CONTENT = 'Test file content';
    protected const string FILE_NAME = 'test.txt';

    protected const int INVALID_FILE_SIZE_KB = 4;
    protected const string INVALID_FILE_MIME_TYPE = 'image/jpeg';
    protected const string INVALID_FILE_NAME = 'test.jpeg';

    protected const string EXPECTED_FILE_UPLOADED_MESSAGE = 'File uploaded';
}
