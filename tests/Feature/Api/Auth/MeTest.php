<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Constants\WithAuthConstants;
use Tests\Traits\WithUser;

class MeTest extends TestCase
{
    use RefreshDatabase, WithUser, WithAuthConstants, WithResponseAssertions;

    public function testMeSuccess(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);

        $response = $this->withToken($token)
            ->getJson(self::ME_URI);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'user' => self::ME_RESPONSE_USER_JSON_STRUCTURE,
            ]);
    }

    public function testMeSuccessHasJsonContentType(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);

        $response = $this->withToken($token)
            ->getJson(self::ME_URI);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(200, self::CONTENT_TYPE_HEADER_NAME, self::JSON_MIME_TYPE);
    }

    public function testMeSuccessDoesNotContainPassword(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);

        $response = $this->withToken($token)
            ->getJson(self::ME_URI);

        $this->withResponse($response)
            ->assertStatusWithoutJsonPathAndJson(200, 'user.password', ['password']);
    }

    public function testMeWithoutAuthentication(): void
    {
        $response = $this->getJson(self::ME_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testMeWithoutAuthenticationHasJsonContentType(): void
    {
        $response = $this->getJson(self::ME_URI);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(401, self::CONTENT_TYPE_HEADER_NAME, self::JSON_MIME_TYPE);
    }

    public function testMeWithInvalidToken(): void
    {
        $response = $this->withToken(self::INVALID_TOKEN)
            ->getJson(self::ME_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testMeWithInvalidTokenHasJsonContentType(): void
    {
        $response = $this->withToken(self::INVALID_TOKEN)
            ->getJson(self::ME_URI);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(401, self::CONTENT_TYPE_HEADER_NAME, self::JSON_MIME_TYPE);
    }
}
