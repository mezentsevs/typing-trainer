<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Feature\Traits\Assertions\WithResponseAssertions;
use Tests\Feature\Traits\WithUser;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithUser, WithResponseAssertions;

    private const string API_REGISTER_URI = '/api/register';
    private const string API_LOGIN_URI = '/api/login';
    private const string API_LOGOUT_URI = '/api/logout';
    private const string API_LESSONS_URI_TEMPLATE = '/api/lessons/%s/%d';

    private const int TEST_LESSON_NUMBER = 1;
    private const string TEST_TOKEN_NAME = 'test_token';
    private const string TEST_ANOTHER_TOKEN_NAME = 'another_token';
    private const string TEST_EMAIL = 'test@example.com';
    private const string TEST_NAME = 'Test User';
    private const string TEST_ANOTHER_NAME = 'Another User';
    private const string TEST_PASSWORD = 'password';
    private const string TEST_ANOTHER_PASSWORD = 'another_password';

    private const string TEST_INVALID_EMAIL = 'invalid_email';
    private const string TEST_INVALID_EMPTY_EMAIL = '';
    private const string TEST_INVALID_EMPTY_NAME = '';
    private const string TEST_INVALID_EMPTY_PASSWORD = '';
    private const string TEST_INVALID_PASSWORD = 'wrong_password';
    private const string TEST_INVALID_SHORT_PASSWORD = 'short';

    public function testUserRegistrationSuccess(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_NAME,
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(201, [
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function testUserRegistrationValidationNameRequired(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'name', 'The name field is required.');
    }

    public function testUserRegistrationValidationNameNotEmpty(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_INVALID_EMPTY_NAME,
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'name', 'The name field is required.');
    }

    public function testUserRegistrationValidationEmailRequired(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_NAME,
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testUserRegistrationValidationEmailNotEmpty(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_NAME,
            'email' => self::TEST_INVALID_EMPTY_EMAIL,
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testUserRegistrationValidationEmailMustBeValid(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_NAME,
            'email' => self::TEST_INVALID_EMAIL,
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field must be a valid email address.');
    }

    public function testUserRegistrationValidationEmailMustBeUnique(): void
    {
        $this->createUser([
            'name' => self::TEST_NAME,
            'email' => self::TEST_EMAIL,
        ]);

        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_ANOTHER_NAME,
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_ANOTHER_PASSWORD,
            'password_confirmation' => self::TEST_ANOTHER_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email has already been taken.');
    }

    public function testUserRegistrationValidationPasswordRequired(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_NAME,
            'email' => self::TEST_EMAIL,
            'password_confirmation' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testUserRegistrationValidationPasswordNotEmpty(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_NAME,
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_INVALID_EMPTY_PASSWORD,
            'password_confirmation' => self::TEST_INVALID_EMPTY_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testUserRegistrationValidationPasswordMinimumLength(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_NAME,
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_INVALID_SHORT_PASSWORD,
            'password_confirmation' => self::TEST_INVALID_SHORT_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field must be at least 8 characters.');
    }

    public function testUserRegistrationValidationPasswordConfirmationRequired(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_NAME,
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field confirmation does not match.');
    }

    public function testUserRegistrationValidationPasswordConfirmationNotEmpty(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_NAME,
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_INVALID_EMPTY_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field confirmation does not match.');
    }

    public function testUserRegistrationValidationPasswordConfirmationMustMatch(): void
    {
        $response = $this->postJson(self::API_REGISTER_URI, [
            'name' => self::TEST_NAME,
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_INVALID_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field confirmation does not match.');
    }

    public function testUserLoginSuccess(): void
    {
        $this->createUser(['email' => self::TEST_EMAIL]);

        $response = $this->postJson(self::API_LOGIN_URI, [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function testUserLoginValidationEmailRequired(): void
    {
        $response = $this->postJson(self::API_LOGIN_URI, [
            'password' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testUserLoginValidationEmailNotEmpty(): void
    {
        $response = $this->postJson(self::API_LOGIN_URI, [
            'email' => self::TEST_INVALID_EMPTY_EMAIL,
            'password' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testUserLoginValidationEmailMustBeValid(): void
    {
        $response = $this->postJson(self::API_LOGIN_URI, [
            'email' => self::TEST_INVALID_EMAIL,
            'password' => self::TEST_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field must be a valid email address.');
    }

    public function testUserLoginValidationPasswordRequired(): void
    {
        $this->createUser(['email' => self::TEST_EMAIL]);

        $response = $this->postJson(self::API_LOGIN_URI, [
            'email' => self::TEST_EMAIL,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testUserLoginValidationPasswordNotEmpty(): void
    {
        $this->createUser(['email' => self::TEST_EMAIL]);

        $response = $this->postJson(self::API_LOGIN_URI, [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_INVALID_EMPTY_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testUserLoginWithInvalidCredentials(): void
    {
        $response = $this->postJson(self::API_LOGIN_URI, [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_INVALID_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Invalid credentials');
    }

    public function testUserLogoutSuccess(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TEST_TOKEN_NAME);

        $response = $this->withToken($token)
            ->postJson(self::API_LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Logged out');
    }

    public function testUserLogoutWithoutAuthentication(): void
    {
        $response = $this->postJson(self::API_LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testUserLogoutInvalidatesAllTokens(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TEST_TOKEN_NAME);
        $this->createTokenForUser($user, self::TEST_ANOTHER_TOKEN_NAME);
        $expectedTokensCount = 2;

        $this->assertEquals(
            $expectedTokensCount,
            $user->tokens()->count(),
            "User should have {$expectedTokensCount} tokens before logout.",
        );

        $this->withToken($token)
            ->postJson(self::API_LOGOUT_URI);

        $this->assertEquals(0, $user->tokens()->count(), 'User should have no tokens after logout.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonAccessWithoutAuthentication(string $language): void
    {
        $uri = sprintf(self::API_LESSONS_URI_TEMPLATE, $language, self::TEST_LESSON_NUMBER);

        $response = $this->getJson($uri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }
}
