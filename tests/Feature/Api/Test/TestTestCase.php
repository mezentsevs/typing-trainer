<?php

namespace Tests\Feature\Api\Test;

use Tests\Feature\Api\ApiTestCase;
use Tests\Traits\Constants\WithGenreConstants;
use Tests\Traits\Constants\WithLanguageConstants;
use Tests\Traits\Constants\WithTestConstants;

abstract class TestTestCase extends ApiTestCase
{
    use WithGenreConstants,
        WithLanguageConstants,
        WithTestConstants;
}
