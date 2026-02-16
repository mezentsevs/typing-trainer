<?php

namespace Tests\Feature\Api\Lessons;

use App\Traits\Constants\WithLessonConstants as WithAppLessonConstants;
use Tests\Feature\Api\ApiTestCase;
use Tests\Traits\Constants\WithLanguageConstants;
use Tests\Traits\Constants\WithLessonConstants;

abstract class LessonTestCase extends ApiTestCase
{
    use WithAppLessonConstants,
        WithLanguageConstants,
        WithLessonConstants;
}
