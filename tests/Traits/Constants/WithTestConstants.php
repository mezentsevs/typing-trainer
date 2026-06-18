<?php

namespace Tests\Traits\Constants;

trait WithTestConstants
{
    protected const string TEST_RETRIEVE_URI = '/api/test/retrieve';
    protected const string TEST_RETRIEVE_URI_TEMPLATE = self::TEST_RETRIEVE_URI . '?language=%s&genre=%s';
    protected const string TEST_RETRIEVE_URI_TEMPLATE_WITH_LANGUAGE_ONLY = self::TEST_RETRIEVE_URI . '?language=%s';
    protected const string TEST_RETRIEVE_URI_TEMPLATE_WITH_GENRE_ONLY = self::TEST_RETRIEVE_URI . '?genre=%s';
    protected const string TEST_UPLOAD_URI = '/api/test/upload';
    protected const string TEST_RESULT_URI = '/api/test/result';
    protected const string TEST_RESULT_URI_TEMPLATE = self::TEST_RESULT_URI . '?language=%s&time_seconds=%d&speed_wpm=%d&errors=%d';

    protected const array TEST_RETRIEVE_RESPONSE_JSON_STRUCTURE = ['text'];

    protected const array TEST_UPLOAD_RESPONSE_JSON_STRUCTURE = [
        'message',
        'path',
    ];

    protected const array TEST_RESULT_RESPONSE_JSON_STRUCTURE = [
        'id',
        'user_id',
        'language',
        'time_seconds',
        'speed_wpm',
        'errors',
        'created_at',
        'updated_at',
    ];
}
