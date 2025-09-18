<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Feature\Traits\Assertions\WithResponseAssertions;
use Tests\Feature\Traits\WithUser;
use Tests\Providers\AuthDataProvider;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithUser, WithResponseAssertions;

    private const string REGISTER_URI = '/api/register';
    private const string LOGIN_URI = '/api/login';
    private const string LOGOUT_URI = '/api/logout';
    private const string LESSONS_URI_TEMPLATE = '/api/lessons/%s/%d';

    private const string TOKEN_NAME = 'test_token';
    private const string ANOTHER_TOKEN_NAME = 'another_token';

    private const string EMAIL = 'test@example.com';
    private const string INVALID_EMAIL = 'invalid_email';
    private const string INVALID_EMPTY_EMAIL = '';

    private const int MAX_USER_NAME_LENGTH = 255;
    private const string USER_NAME = 'Test User';
    private const string ANOTHER_USER_NAME = 'Another User';
    private const string INVALID_EMPTY_USER_NAME = '';

    private const string PASSWORD = 'password';
    private const string ANOTHER_PASSWORD = 'another_password';
    private const string WRONG_PASSWORD = 'wrong_password';
    private const string INVALID_SHORT_PASSWORD = 'short';
    private const string INVALID_EMPTY_PASSWORD = '';

    private const int LESSON_NUMBER = 1;

    public function testUserRegistrationSuccess(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
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
        $response = $this->postJson(self::REGISTER_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'name', 'The name field is required.');
    }

    public function testUserRegistrationValidationNameNotEmpty(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::INVALID_EMPTY_USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'name', 'The name field is required.');
    }

    public function testUserRegistrationValidationNameMaximumLength(): void
    {
        $longUserName = str_repeat('a', self::MAX_USER_NAME_LENGTH + 1);

        $response = $this->postJson(self::REGISTER_URI, [
            'name' => $longUserName,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'name', 'The name field must not be greater than 255 characters.');
    }

    #[DataProviderExternal(AuthDataProvider::class, 'provideValidFormatNames')]
    public function testUserRegistrationValidationNameFormatIsValid(string $name): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => $name,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertStatus(201);
    }

    #[DataProviderExternal(AuthDataProvider::class, 'provideInvalidFormatNames')]
    public function testUserRegistrationValidationNameFormatIsInvalid(string $name): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => $name,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'name', 'The name field format is invalid.');
    }

    public function testUserRegistrationValidationEmailRequired(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testUserRegistrationValidationEmailNotEmpty(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::INVALID_EMPTY_EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testUserRegistrationValidationEmailMustBeValid(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::INVALID_EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field must be a valid email address.');
    }

    public function testUserRegistrationValidationEmailMustBeUnique(): void
    {
        $this->createUser([
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
        ]);

        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::ANOTHER_USER_NAME,
            'email' => self::EMAIL,
            'password' => self::ANOTHER_PASSWORD,
            'password_confirmation' => self::ANOTHER_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email has already been taken.');
    }

    public function testUserRegistrationValidationPasswordRequired(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testUserRegistrationValidationPasswordNotEmpty(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::INVALID_EMPTY_PASSWORD,
            'password_confirmation' => self::INVALID_EMPTY_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testUserRegistrationValidationPasswordMinimumLength(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::INVALID_SHORT_PASSWORD,
            'password_confirmation' => self::INVALID_SHORT_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field must be at least 8 characters.');
    }

    public function testUserRegistrationValidationPasswordConfirmationRequired(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field confirmation does not match.');
    }

    public function testUserRegistrationValidationPasswordConfirmationNotEmpty(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::INVALID_EMPTY_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field confirmation does not match.');
    }

    public function testUserRegistrationValidationPasswordConfirmationMustMatch(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::WRONG_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field confirmation does not match.');
    }

    public function testUserLoginSuccess(): void
    {
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
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
        $response = $this->postJson(self::LOGIN_URI, [
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testUserLoginValidationEmailNotEmpty(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::INVALID_EMPTY_EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testUserLoginValidationEmailMustBeValid(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::INVALID_EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field must be a valid email address.');
    }

    public function testUserLoginValidationPasswordRequired(): void
    {
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testUserLoginValidationPasswordNotEmpty(): void
    {
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::INVALID_EMPTY_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testUserLoginWithInvalidCredentials(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Invalid credentials');
    }

    public function testUserLogoutSuccess(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Logged out');
    }

    public function testUserLogoutWithoutAuthentication(): void
    {
        $response = $this->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testUserLogoutInvalidatesAllTokens(): void
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
    public function testLessonAccessWithoutAuthentication(string $language): void
    {
        $uri = sprintf(self::LESSONS_URI_TEMPLATE, $language, self::LESSON_NUMBER);

        $response = $this->getJson($uri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }
}
