<?php

namespace Tests\Traits\Constants;

trait WithLessonConstants
{
    protected const int LESSON_NUMBER_FOR_ACCESS = 1;
    protected const int MULTIPLE_LESSON_COUNT = 5;
    protected const int SINGLE_LESSON_COUNT = 1;

    protected const int INVALID_LESSON_COUNT = 0;

    protected const string LESSONS_SHOW_URI_TEMPLATE = '/api/lessons/%s/%d';
    protected const array LESSONS_SHOW_RESPONSE_LESSON_JSON_STRUCTURE = [
        'id',
        'user_id',
        'number',
        'total',
        'language',
        'new_chars',
        'text',
        'created_at',
        'updated_at',
    ];

    protected const array LESSONS_RESULT_RESPONSE_JSON_STRUCTURE = [
        'id',
        'user_id',
        'lesson_id',
        'language',
        'time_seconds',
        'speed_wpm',
        'errors',
        'created_at',
        'updated_at',
    ];
}
