<?php

namespace Tests\Feature\Api\Lessons;

use App\Traits\Constants\WithDatabaseConstants;
use App\Traits\Constants\WithLessonConstants as WithAppLessonConstants;
use App\Traits\Constants\WithStatisticsConstants as WithAppStatisticsConstants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Constants\WithLanguageConstants;
use Tests\Traits\Constants\WithLessonConstants;
use Tests\Traits\Constants\WithStatisticsConstants;
use Tests\Traits\Constants\WithTokenConstants;
use Tests\Traits\WithLesson;
use Tests\Traits\WithUri;
use Tests\Traits\WithUser;

class LessonsResultTest extends TestCase
{
    use RefreshDatabase,
        WithUser,
        WithLesson,
        WithTokenConstants,
        WithDatabaseConstants,
        WithResponseAssertions,
        WithUri,
        WithLanguageConstants,
        WithAppLessonConstants,
        WithLessonConstants,
        WithAppStatisticsConstants,
        WithStatisticsConstants;
}
