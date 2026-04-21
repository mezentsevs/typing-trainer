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
}
