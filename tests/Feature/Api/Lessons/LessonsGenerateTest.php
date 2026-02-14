<?php

namespace Tests\Feature\Api\Lessons;

use App\Traits\Constants\WithDatabaseConstants;
use App\Traits\Constants\WithLessonConstants as WithAppLessonConstants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Constants\WithLanguageConstants;
use Tests\Traits\Constants\WithLessonConstants;
use Tests\Traits\Constants\WithTokenConstants;
use Tests\Traits\WithUri;
use Tests\Traits\WithUser;

class LessonsGenerateTest extends TestCase
{
    use RefreshDatabase,
        WithUser,
        WithTokenConstants,
        WithDatabaseConstants,
        WithResponseAssertions,
        WithUri,
        WithLanguageConstants,
        WithAppLessonConstants,
        WithLessonConstants;
}
