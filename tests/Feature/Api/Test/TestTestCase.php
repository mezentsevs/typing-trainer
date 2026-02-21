<?php

namespace Tests\Feature\Api\Test;

use App\Traits\Constants\WithStatisticsConstants as WithAppStatisticsConstants;
use Tests\Feature\Api\ApiTestCase;
use Tests\Traits\Constants\WithFileConstants;
use Tests\Traits\Constants\WithLanguageConstants;
use Tests\Traits\Constants\WithStatisticsConstants;
use Tests\Traits\Constants\WithTestConstants;

abstract class TestTestCase extends ApiTestCase
{
    use WithAppStatisticsConstants,
        WithFileConstants,
        WithLanguageConstants,
        WithStatisticsConstants,
        WithTestConstants;
}
