<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Fakes\WithAuthFakes;
use Tests\Traits\WithUser;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithUser, WithResponseAssertions, WithAuthFakes;

    public function testLoginSuccess(): void
    {
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'token',
                'user' => self::LOGIN_RESPONSE_USER_JSON_STRUCTURE,
            ]);
    }

    public function testLoginReturnsCorrectHttpHeaders(): void
    {
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(200, self::CONTENT_TYPE_HEADER_NAME, self::JSON_MIME_TYPE);
    }

    public function testLoginTokenWorksForProtectedEndpoint(): void
    {
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'token',
                'user' => self::LOGIN_RESPONSE_USER_JSON_STRUCTURE,
            ]);

        $token = $response->json('token');
        $this->assertNotNull($token, 'Token should be present in response.');

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Logged out');
    }

    public function testLoginWithoutEmail(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testLoginWithEmptyEmail(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::INVALID_EMPTY_EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testLoginWithValidLongEmail(): void
    {
        $email = $this->fakeValidLongEmail();
        $this->createUser(['email' => $email]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => $email,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'token',
                'user' => self::LOGIN_RESPONSE_USER_JSON_STRUCTURE,
            ]);
    }

    public function testLoginWithInvalidLongEmail(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'email' => $this->fakeInvalidLongEmail(),
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field must not be greater than 255 characters.');
    }

    public function testLoginWithInvalidEmail(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::INVALID_EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field must be a valid email address.');
    }

    public function testLoginTrimsSpacesFromEmail(): void
    {
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => '   ' . self::EMAIL . '   ',
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'token',
                'user' => self::LOGIN_RESPONSE_USER_JSON_STRUCTURE,
            ]);

        $this->assertEquals(self::EMAIL, $response->json('user.email'), 'Email should be trimmed.');
    }

    public function testLoginWithEmailCaseInsensitivity(): void
    {
        $email = strtolower(self::EMAIL);
        $this->createUser(['email' => $email]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => strtoupper(self::EMAIL),
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'token',
                'user' => self::LOGIN_RESPONSE_USER_JSON_STRUCTURE,
            ]);

        $this->assertEquals(
            $email,
            $response->json('user.email'),
            'Response should return email in lowercase as stored in database.',
        );
    }

    public function testLoginWithUnverifiedEmail(): void
    {
        $this->createUser([
            'email' => self::EMAIL,
            'email_verified_at' => null,
        ]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'token',
                'user' => self::LOGIN_RESPONSE_USER_JSON_STRUCTURE,
            ]);

        $this->assertNull(
            $response->json('user.email_verified_at'),
            'User with unverified email should be able to login.',
        );
    }

    public function testLoginWithoutPassword(): void
    {
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testLoginWithEmptyPassword(): void
    {
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::INVALID_EMPTY_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testLoginWithValidLongPassword(): void
    {
        $password = $this->fakeValidLongPassword();

        $this->createUser([
            'email' => self::EMAIL,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => $password,
        ]);

        $response->assertStatus(200);
    }

    public function testLoginWithInvalidLongPassword(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => $this->fakeInvalidLongPassword(),
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'password',
                'The password field must not be greater than 255 characters.',
            );
    }

    public function testLoginSuccessResponseDoesNotContainPassword(): void
    {
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithoutJsonPathAndJson(200, 'user.password', ['password']);
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Invalid credentials');
    }

    public function testLoginWithDeletedUser(): void
    {
        $user = $this->createUser(['email' => self::EMAIL]);
        $user->delete();

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Invalid credentials');
    }

    public function testLoginWithOldEmailAfterChange(): void
    {
        $user = $this->createUser(['email' => self::EMAIL]);
        $user->update(['email' => self::ANOTHER_EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Invalid credentials');
    }

    public function testLoginWithOldPasswordAfterChange(): void
    {
        $user = $this->createUser(['email' => self::EMAIL]);
        $user->update(['password' => Hash::make(self::ANOTHER_PASSWORD)]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Invalid credentials');
    }
}
