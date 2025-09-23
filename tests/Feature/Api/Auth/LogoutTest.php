<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Constants\WithAuthConstants;
use Tests\Traits\WithUser;

class LogoutTest extends TestCase
{
    use RefreshDatabase, WithUser, WithResponseAssertions, WithAuthConstants;

    private const string LESSONS_URI_TEMPLATE = '/api/lessons/%s/%d';
    private const int LESSON_NUMBER_FOR_ACCESS = 1;

    public function testLogoutSuccess(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Logged out');
    }

    public function testLogoutWithoutAuthentication(): void
    {
        $response = $this->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testLogoutMustInvalidateAllTokens(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);
        $this->createTokenForUser($user, self::ANOTHER_TOKEN_NAME);
        $expectedTokensCount = 2;

        $this->assertEquals(
            $expectedTokensCount,
            $user->tokens()->count(),
            "User should have {$expectedTokensCount} tokens before logout.",
        );

        $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->assertEquals(0, $user->tokens()->count(), 'User should have no tokens after logout.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testAccessLessonWithoutAuthentication(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }
}
