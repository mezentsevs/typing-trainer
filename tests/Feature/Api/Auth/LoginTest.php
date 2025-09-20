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

    private const string LOGIN_URI = '/api/login';

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
            'password' => Hash::make(self::PASSWORD),
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
}
