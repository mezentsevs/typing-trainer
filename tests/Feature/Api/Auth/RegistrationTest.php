<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\AuthDataProvider;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Fakes\WithAuthFakes;
use Tests\Traits\WithUser;

class RegistrationTest extends TestCase
{
    use RefreshDatabase, WithUser, WithResponseAssertions, WithAuthFakes;

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

    public function testRegistrationReturnsCorrectHttpHeaders(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertStatus(201);
        $response->assertHeader(self::CONTENT_TYPE_HEADER, self::JSON_MIME_TYPE);
    }

    public function testRegistrationTokenWorksForProtectedEndpoint(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertStatus(201);

        $token = $response->json('token');
        $this->assertNotNull($token, 'Token should be present in response.');

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Logged out');
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

    public function testRegistrationTrimsSpacesFromUserName(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => '   ' . self::USER_NAME . '   ',
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertStatus(201);

        $user = User::where('email', self::EMAIL)->first();
        $this->assertNotNull($user, 'User should be created.');
        $this->assertEquals(self::USER_NAME, $user->name, 'User name should be trimmed.');
    }

    public function testRegistrationWithSqlInjectionAttemptInUserName(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME_WITH_SQL_INJECTION,
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
        $this->createUser(['email' => self::EMAIL]);

        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::ANOTHER_USER_NAME,
            'email' => self::EMAIL,
            'password' => self::ANOTHER_PASSWORD,
            'password_confirmation' => self::ANOTHER_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email has already been taken.');
    }

    public function testRegistrationWithEmailCaseInsensitivity(): void
    {
        $this->createUser(['email' => strtolower(self::EMAIL)]);

        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::ANOTHER_USER_NAME,
            'email' => strtoupper(self::EMAIL),
            'password' => self::ANOTHER_PASSWORD,
            'password_confirmation' => self::ANOTHER_PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email has already been taken.');
    }

    public function testRegistrationTrimsSpacesFromEmail(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => '   ' . self::EMAIL . '   ',
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertStatus(201);

        $user = User::where('email', self::EMAIL)->first();
        $this->assertNotNull($user, 'User should be created.');
        $this->assertEquals(self::EMAIL, $user->email, 'Email should be trimmed.');
    }

    public function testRegistrationWithSqlInjectionAttemptInEmail(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL_WITH_SQL_INJECTION,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'email', 'The email field must be a valid email address.');
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

    public function testRegistrationStoresHashedPassword(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertStatus(201);

        $user = User::where('email', self::EMAIL)->first();

        $this->assertNotNull($user, 'User should be created.');
        $this->assertNotEquals(self::PASSWORD, $user->password, 'Password should not be stored in plain text.');
        $this->assertTrue(
            Hash::check(self::PASSWORD, $user->password),
            'Password hash should match the provided password hash.',
        );
    }

    public function testRegistrationSuccessResponseDoesNotContainPassword(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertStatus(201);
        $response->assertJsonMissing(['password']);
        $response->assertJsonMissingPath('user.password');
    }

    public function testRegistrationWithSqlInjectionAttemptInPassword(): void
    {
        $response = $this->postJson(self::REGISTER_URI, [
            'name' => self::USER_NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD_WITH_SQL_INJECTION,
            'password_confirmation' => self::PASSWORD_WITH_SQL_INJECTION,
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
}
