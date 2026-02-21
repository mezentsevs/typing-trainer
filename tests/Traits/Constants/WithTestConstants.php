<?php

namespace Tests\Traits\Constants;

trait WithTestConstants
{
    protected const string TEST_TEXT_URI_TEMPLATE = '/api/test/text?language=%s';
    protected const string TEST_UPLOAD_URI = '/api/test/upload';
    protected const string TEST_RESULT_URI = '/api/test/result';

    protected const array TEST_TEXT_RESPONSE_JSON_STRUCTURE = ['text'];
}
