<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Traits\Constants\WithStatisticsConstants as WithAppStatisticsConstants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Constants\WithFileConstants;
use Tests\Traits\Constants\WithLanguageConstants;
use Tests\Traits\Constants\WithStatisticsConstants;
use Tests\Traits\Constants\WithTokenConstants;
use Tests\Traits\WithUser;

class TestsTest extends TestCase
{
    use RefreshDatabase,
        WithUser,
        WithTokenConstants,
        WithLanguageConstants,
        WithAppStatisticsConstants,
        WithStatisticsConstants,
        WithFileConstants,
        WithResponseAssertions;

    private string $token;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->token = $this->createTokenForUser($this->user, self::TOKEN_NAME);
    }
}
