<?php

namespace Tests\Feature\Api;

use App\Enums\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\WithUser;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithUser;

    private const string TEST_EMAIL = 'test@example.com';
    private const string TEST_EMPTY_NAME = '';
    private const string TEST_INVALID_EMAIL_FORMAT = 'invalid_email';
    private const string TEST_NAME = 'Test User';
    private const string TEST_PASSWORD = 'password';
    private const string TEST_PASSWORD_MISMATCH = 'mismatch';
    private const string TEST_SHORT_PASSWORD = 'short';
    private const string TEST_TOKEN_NAME = 'test_token';
    private const string TEST_WRONG_PASSWORD = 'wrong_password';

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
            'name' => self::TEST_EMPTY_NAME,
            'email' => self::TEST_INVALID_EMAIL_FORMAT,
            'password' => self::TEST_SHORT_PASSWORD,
            'password_confirmation' => self::TEST_PASSWORD_MISMATCH,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'email',
                'password',
            ]);
    }

    public function testUserLoginValidation(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => self::TEST_INVALID_EMAIL_FORMAT,
            'password' => self::TEST_EMPTY_NAME,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
                'password',
            ]);
    }

    public function testInvalidLoginCredentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_WRONG_PASSWORD,
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => self::EXPECTED_INVALID_CREDENTIALS_MESSAGE]);
    }

    public function testUnauthenticatedAccess(): void
    {
        $response = $this->getJson('/api/lessons/' . Language::En->value . '/1');
        $response->assertStatus(401);
    }
}
