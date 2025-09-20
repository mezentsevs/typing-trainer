<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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

    private const string TOKEN_NAME = 'testToken';
    private const string ANOTHER_TOKEN_NAME = 'anotherToken';

    private const int MAX_EMAIL_LENGTH = 255;
    private const string EMAIL = 'test@example.com';
    private const string EMAIL_DOMAIN = '@example.com';
    private const string INVALID_EMAIL = 'invalidEmail';
    private const string INVALID_EMPTY_EMAIL = '';

    private const int MAX_USER_NAME_LENGTH = 255;
    private const string USER_NAME = 'Test User';
    private const string ANOTHER_USER_NAME = 'Another User';
    private const string INVALID_EMPTY_USER_NAME = '';

    private const int MIN_PASSWORD_LENGTH = 8;
    private const int MAX_PASSWORD_LENGTH = 255;
    private const string PASSWORD = 'password';
    private const string ANOTHER_PASSWORD = 'anotherPassword';
    private const string INVALID_EMPTY_PASSWORD = '';

    private const int LESSON_NUMBER_FOR_ACCESS = 1;

    public function testRegistrationSuccess(): void
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

    public function testRegistrationWithoutUserName(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'name', 'The name field is required.');
    }

    public function testRegistrationWithEmptyUserName(): void
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

    public function testRegistrationWithValidLongUserName(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => $this->fakeValidLongUserName(),
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertStatus(201);
    }

    private function fakeValidLongUserName(): string
    {
        return str_repeat('a', self::MAX_USER_NAME_LENGTH);
    }

    public function testRegistrationWithInvalidLongUserName(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => $this->fakeInvalidLongUserName(),
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'name', 'The name field must not be greater than 255 characters.');
    }

    private function fakeInvalidLongUserName(): string
    {
        return str_repeat('a', self::MAX_USER_NAME_LENGTH + 1);
    }

    #[DataProviderExternal(AuthDataProvider::class, 'provideValidUserNames')]
    public function testRegistrationWithValidUserName(string $userName): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => $userName,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertStatus(201);
    }

    #[DataProviderExternal(AuthDataProvider::class, 'provideInvalidUserNames')]
    public function testRegistrationWithInvalidUserName(string $userName): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => $userName,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'name', 'The name field format is invalid.');
    }

    public function testRegistrationWithoutEmail(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field is required.');
    }

    public function testRegistrationWithEmptyEmail(): void
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

    public function testRegistrationWithValidLongEmail(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => $this->fakeValidLongEmail(),
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertStatus(201);
    }

    private function fakeValidLongEmail(): string
    {
        return str_repeat('a', $this->calcMaxEmailLocalPartLength()) . self::EMAIL_DOMAIN;
    }

    private function calcMaxEmailLocalPartLength(): int
    {
        return self::MAX_EMAIL_LENGTH - strlen(self::EMAIL_DOMAIN);
    }

    public function testRegistrationWithInvalidLongEmail(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => $this->fakeInvalidLongEmail(),
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field must not be greater than 255 characters.');
    }

    private function fakeInvalidLongEmail(): string
    {
        return str_repeat('a', $this->calcMaxEmailLocalPartLength() + 1) . self::EMAIL_DOMAIN;
    }

    public function testRegistrationWithInvalidEmail(): void
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

    public function testRegistrationWithNotUniqueEmail(): void
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

    public function testRegistrationWithoutPassword(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field is required.');
    }

    public function testRegistrationWithEmptyPassword(): void
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

    public function testRegistrationWithValidShortPassword(): void
    {
        $password = $this->fakeValidShortPassword();

        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(201);
    }

    private function fakeValidShortPassword(): string
    {
        return str_repeat('a', self::MIN_PASSWORD_LENGTH);
    }

    public function testRegistrationWithInvalidShortPassword(): void
    {
        $password = $this->fakeInvalidShortPassword();

        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field must be at least 8 characters.');
    }

    private function fakeInvalidShortPassword(): string
    {
        return str_repeat('a', self::MIN_PASSWORD_LENGTH - 1);
    }

    public function testRegistrationWithValidLongPassword(): void
    {
        $password = $this->fakeValidLongPassword();

        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(201);
    }

    private function fakeValidLongPassword(): string
    {
        return str_repeat('a', self::MAX_PASSWORD_LENGTH);
    }

    public function testRegistrationWithInvalidLongPassword(): void
    {
        $password = $this->fakeInvalidLongPassword();

        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'password',
                'The password field must not be greater than 255 characters.',
            );
    }

    private function fakeInvalidLongPassword(): string
    {
        return str_repeat('a', self::MAX_PASSWORD_LENGTH + 1);
    }

    #[DataProviderExternal(AuthDataProvider::class, 'provideValidPasswords')]
    public function testRegistrationWithValidPassword(string $password): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(201);
    }

    #[DataProviderExternal(AuthDataProvider::class, 'provideInvalidPasswords')]
    public function testRegistrationWithInvalidPassword(string $password): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field format is invalid.');
    }

    public function testRegistrationWithoutPasswordConfirmation(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field confirmation does not match.');
    }

    public function testRegistrationWithEmptyPasswordConfirmation(): void
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

    public function testRegistrationWithMismatchPasswordConfirmation(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::ANOTHER_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'password', 'The password field confirmation does not match.');
    }

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

        $this->createUser([
            'email' => $email,
            'password' => self::PASSWORD,
        ]);

        $response = $this->postJson(self::LOGIN_URI, [
            'email' => $email,
            'password' => self::PASSWORD,
        ]);

        $response->assertStatus(200);
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

    public function testLoginWithInvalidCredentials(): void
    {
        $response = $this->postJson(self::LOGIN_URI, [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Invalid credentials');
    }

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
