<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Feature\Traits\WithUser;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithUser;

    private const string TEST_TOKEN_NAME = 'test_token';

    private const string TEST_EMAIL = 'test@example.com';
    private const string TEST_NAME = 'Test User';
    private const string TEST_PASSWORD = 'password';

    private const string TEST_INVALID_EMAIL = 'invalid_email';
    private const string TEST_INVALID_EMPTY_NAME = '';
    private const string TEST_INVALID_EMPTY_PASSWORD = '';
    private const string TEST_INVALID_PASSWORD = 'wrong_password';
    private const string TEST_INVALID_SHORT_PASSWORD = 'short';

    private const int TEST_LESSON_NUMBER = 1;

    private const string EXPECTED_INVALID_CREDENTIALS_MESSAGE = 'Invalid credentials';

    public function testUserRegistration(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => self::TEST_NAME,
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_PASSWORD,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'token',
                'user',
            ]);
    }

    public function testUserLogin(): void
    {
        $this->createUser([
            'email' => self::TEST_EMAIL,
            'password' => bcrypt(self::TEST_PASSWORD),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'user',
            ]);
    }

    public function testUserLogout(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TEST_TOKEN_NAME);

        $response = $this->withToken($token)
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out']);
    }

    public function testUserRegistrationValidation(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => self::TEST_INVALID_EMPTY_NAME,
            'email' => self::TEST_INVALID_EMAIL,
            'password' => self::TEST_INVALID_SHORT_PASSWORD,
            'password_confirmation' => self::TEST_INVALID_PASSWORD,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'email',
                'password',
            ]);
    }

    public function testUserLoginEmailValidation(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => self::TEST_INVALID_EMAIL,
            'password' => self::TEST_PASSWORD,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function testUserLoginPasswordValidation(): void
    {
        $this->createUser([
            'email' => self::TEST_EMAIL,
            'password' => bcrypt(self::TEST_PASSWORD),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_INVALID_EMPTY_PASSWORD,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function testInvalidLoginCredentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_INVALID_PASSWORD,
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => self::EXPECTED_INVALID_CREDENTIALS_MESSAGE]);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testUnauthenticatedAccess(string $language): void
    {
        $response = $this->getJson('/api/lessons/' . $language . '/' . self::TEST_LESSON_NUMBER);
        $response->assertStatus(401);
    }
}
