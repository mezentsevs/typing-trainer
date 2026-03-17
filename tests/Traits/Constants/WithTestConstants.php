<?php

namespace Tests\Traits\Constants;

trait WithTestConstants
{
    protected const string TEST_TEXT_URI_BASE = '/api/test/text';
    protected const string TEST_TEXT_URI_TEMPLATE = self::TEST_TEXT_URI_BASE . '?language=%s&genre=%s';
    protected const string TEST_TEXT_URI_TEMPLATE_WITH_LANGUAGE_ONLY = self::TEST_TEXT_URI_BASE . '?language=%s';
    protected const string TEST_TEXT_URI_TEMPLATE_WITH_GENRE_ONLY = self::TEST_TEXT_URI_BASE . '?genre=%s';
    protected const string TEST_UPLOAD_URI = '/api/test/upload';
    protected const string TEST_RESULT_URI = '/api/test/result';

    protected const array TEST_TEXT_RESPONSE_JSON_STRUCTURE = ['text'];

    protected const array TEST_UPLOAD_RESPONSE_JSON_STRUCTURE = [
        'message',
        'path',
    ];
}
