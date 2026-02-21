<?php

namespace Tests\Feature\Api\Test;

use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;

class TestsTest extends TestTestCase
{
    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextRetrieveSuccessHasJsonStructure(string $language): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, $language);

        $response = $this->withToken($this->token)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_TEXT_RESPONSE_JSON_STRUCTURE);
    }
}
