<?php

namespace Tests\Traits\Constants;

trait WithWordCharDataProviderConstants
{
    protected const int EXPECTED_MAX_LETTERS_PART_LENGTH = 8;
    protected const int EXPECTED_MIN_LETTERS_PART_LENGTH = 3;

    protected const int EXPECTED_RANDOM_MAX_VALUE = 99;
    protected const int EXPECTED_RANDOM_MIN_VALUE = 0;

    protected const int EXPECTED_DIGIT_USAGE_CHANCE = 30;
    protected const int EXPECTED_NEW_CHAR_USAGE_CHANCE = 70;
}
