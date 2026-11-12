<?php

namespace App\Http\Requests\Lesson;

use App\Http\Requests\BaseRequest;
use App\Traits\HasStatisticsRules;

class LessonSaveResultRequest extends BaseRequest
{
    use HasStatisticsRules;

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
        ] + static::statisticsRules();
    }
}
