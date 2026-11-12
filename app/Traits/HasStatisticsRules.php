<?php

namespace App\Traits;

use App\Rules\LanguageSupported;
use App\Rules\MaxUnsignedInteger;
use App\Traits\Constants\WithStatisticsConstants;

trait HasStatisticsRules
{
    use WithStatisticsConstants;

    public static function statisticsRules(): array
    {
        return [
            'language' => [
                'bail',
                'required',
                'string',
                new LanguageSupported(),
            ],
            'time_seconds' => [
                'bail',
                'required',
                'integer:strict',
                'min:' . self::MIN_TIME_SECONDS,
                new MaxUnsignedInteger(),
            ],
            'speed_wpm' => [
                'bail',
                'required',
                'integer:strict',
                'min:' . self::MIN_SPEED_WPM,
                new MaxUnsignedInteger(),
            ],
            'errors' => [
                'bail',
                'required',
                'integer:strict',
                'min:' . self::MIN_ERRORS_COUNT,
                new MaxUnsignedInteger(),
            ],
            'success' => [
                'bail',
                'required',
                'boolean',
            ],
        ];
    }
}
