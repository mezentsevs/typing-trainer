<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Traits\Constants\WithDatabaseConstants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Constants\WithTokenConstants;
use Tests\Traits\WithUri;
use Tests\Traits\WithUser;

abstract class ApiTestCase extends TestCase
{
    use RefreshDatabase,
        WithDatabaseConstants,
        WithResponseAssertions,
        WithTokenConstants,
        WithUri,
        WithUser;

    protected string $token;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->token = $this->createTokenForUser($this->user, self::TOKEN_NAME);
    }
}
