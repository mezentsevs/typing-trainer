<?php

namespace App\Http\Requests\Lesson;

use App\Http\Requests\BaseRequest;
use App\Rules\LanguageSupported;
use App\Rules\MaxUnsignedInteger;
use App\Traits\Constants\WithStatisticsConstants;

class LessonSaveResultRequest extends BaseRequest
{
    use WithStatisticsConstants;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lesson_id' => [
                'bail',
                'required',
                'integer:strict',
                'exists:lessons,id',
            ],
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
        ];
    }
}
