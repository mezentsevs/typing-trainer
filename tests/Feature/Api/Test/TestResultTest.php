<?php

namespace Tests\Feature\Api\Test;

use App\Enums\Language;
use App\Traits\Constants\WithStatisticsConstants as WithAppStatisticsConstants;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\Traits\Constants\WithStatisticsConstants;

class TestResultTest extends TestTestCase
{
    use WithAppStatisticsConstants, WithStatisticsConstants;

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveSuccess(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveSuccessHasJsonContentType(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(200, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithoutAuthentication(string $language): void
    {
        $response = $this->postJson(self::TEST_RESULT_URI, [
            'language' => $language,
            'time_seconds' => self::TIME_SECONDS,
            'speed_wpm' => self::SPEED_WPM,
            'errors' => self::ERRORS_COUNT,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithoutAuthenticationHasJsonContentType(string $language): void
    {
        $response = $this->postJson(self::TEST_RESULT_URI, [
            'language' => $language,
            'time_seconds' => self::TIME_SECONDS,
            'speed_wpm' => self::SPEED_WPM,
            'errors' => self::ERRORS_COUNT,
        ]);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(401, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithoutAuthenticationHasJsonStructure(string $language): void
    {
        $response = $this->postJson(self::TEST_RESULT_URI, [
            'language' => $language,
            'time_seconds' => self::TIME_SECONDS,
            'speed_wpm' => self::SPEED_WPM,
            'errors' => self::ERRORS_COUNT,
        ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(401, self::MESSAGE_JSON_STRUCTURE);
    }

    public function testTestResultSaveWithMissingLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testTestResultSaveValidationErrorHasJsonContentType(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(422, 'Content-Type', 'application/json');
    }

    public function testTestResultSaveWithNullLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => null,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testTestResultSaveWithEmptyLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => self::INVALID_EMPTY_LANGUAGE,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testTestResultSaveWithUnknownLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => Language::Unknown->value,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    public function testTestResultSaveWithInvalidSqlInjectionLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => self::INVALID_SQL_INJECTION_LANGUAGE,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    public function testTestResultSaveWithInvalidIntLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => self::INVALID_INT_LANGUAGE,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field must be a string.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithMissingTimeSeconds(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithNullTimeSeconds(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => null,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidBoolTimeSeconds(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::INVALID_BOOL_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidStringTimeSeconds(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::INVALID_STRING_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidNumericStringTimeSeconds(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::INVALID_NUMERIC_STRING_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidFloatTimeSeconds(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::INVALID_FLOAT_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithMinTimeSeconds(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::MIN_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithMaxUnsignedIntegerTimeSeconds(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::MAX_UNSIGNED_INTEGER,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithBelowMinTimeSeconds(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::MIN_TIME_SECONDS - 1,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field must be at least 0.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithAboveMaxUnsignedIntegerTimeSeconds(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::MAX_UNSIGNED_INTEGER + 1,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'time_seconds',
                'The time seconds field must not be greater than ' . self::MAX_UNSIGNED_INTEGER . '.',
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithMissingSpeedWpm(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithNullSpeedWpm(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => null,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidBoolSpeedWpm(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::INVALID_BOOL_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidStringSpeedWpm(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::INVALID_STRING_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidNumericStringSpeedWpm(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::INVALID_NUMERIC_STRING_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidFloatSpeedWpm(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::INVALID_FLOAT_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithMinSpeedWpm(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::MIN_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithMaxUnsignedIntegerSpeedWpm(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::MAX_UNSIGNED_INTEGER,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithBelowMinSpeedWpm(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::MIN_SPEED_WPM - 1,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field must be at least 0.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithAboveMaxUnsignedIntegerSpeedWpm(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::MAX_UNSIGNED_INTEGER + 1,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'speed_wpm',
                'The speed wpm field must not be greater than ' . self::MAX_UNSIGNED_INTEGER . '.',
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithMissingErrors(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithNullErrors(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => null,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidBoolErrors(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::INVALID_BOOL_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidStringErrors(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::INVALID_STRING_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidNumericStringErrors(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::INVALID_NUMERIC_STRING_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithInvalidFloatErrors(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::INVALID_FLOAT_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithMinErrors(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::MIN_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithMaxUnsignedIntegerErrors(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::MAX_UNSIGNED_INTEGER,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithBelowMinErrors(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::MIN_ERRORS_COUNT - 1,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field must be at least 0.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithAboveMaxUnsignedIntegerErrors(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_RESULT_URI, [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::MAX_UNSIGNED_INTEGER + 1,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'errors',
                'The errors field must not be greater than ' . self::MAX_UNSIGNED_INTEGER . '.',
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveWithGetMethod(string $language): void
    {
        $testResultUri = sprintf(
            self::TEST_RESULT_URI_TEMPLATE,
            $language,
            self::TIME_SECONDS,
            self::SPEED_WPM,
            self::ERRORS_COUNT,
        );

        $response = $this->withToken($this->token)
            ->getJson($testResultUri);

        $route = $this->normalizeUriForMessage(self::TEST_RESULT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(
                405,
                "The GET method is not supported for route {$route}. Supported methods: POST.",
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestResultSaveMethodNotSupportedHasJsonContentType(string $language): void
    {
        $testResultUri = sprintf(
            self::TEST_RESULT_URI_TEMPLATE,
            $language,
            self::TIME_SECONDS,
            self::SPEED_WPM,
            self::ERRORS_COUNT,
        );

        $response = $this->withToken($this->token)
            ->getJson($testResultUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(405, 'Content-Type', 'application/json');
    }
}
