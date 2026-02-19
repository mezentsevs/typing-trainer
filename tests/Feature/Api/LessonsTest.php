<?php

namespace Tests\Feature\Api;

use App\Models\User;
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

class LessonsTest extends TestCase
{
    use RefreshDatabase,
        WithUser,
        WithLesson,
        WithDatabaseConstants,
        WithTokenConstants,
        WithLanguageConstants,
        WithAppLessonConstants,
        WithLessonConstants,
        WithAppStatisticsConstants,
        WithStatisticsConstants,
        WithResponseAssertions,
        WithUri;

    private string $token;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->token = $this->createTokenForUser($this->user, self::TOKEN_NAME);
    }
}
