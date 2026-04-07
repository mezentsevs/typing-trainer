<?php

namespace Tests\Feature\Api\Test;

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
}
