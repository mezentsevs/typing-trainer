<?php

namespace Tests\Feature\Api\Lessons;

use App\Traits\Constants\WithStatisticsConstants as WithAppStatisticsConstants;
use Tests\Traits\Constants\WithStatisticsConstants;
use Tests\Traits\WithLesson;

class LessonsResultTest extends LessonTestCase
{
    use WithAppStatisticsConstants,
        WithLesson,
        WithStatisticsConstants;
}
