<?php

namespace Tests\Traits\Constants;

trait WithLessonConstants
{
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
