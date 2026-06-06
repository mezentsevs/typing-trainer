<?php

namespace App\Http\Requests\Lesson;

use App\Http\Requests\BaseRequest;
use App\Models\Lesson;
use App\Rules\LanguageSupported;
use App\Traits\Constants\WithLessonConstants;

class LessonGenerateRequest extends BaseRequest
{
    use WithLessonConstants;

    public function authorize(): bool
    {
        return $this->user()->can('create', Lesson::class);
    }

    public function rules(): array
    {
        return [
            'language' => ['bail', 'required', 'string', new LanguageSupported()],
            'lesson_count' => [
                'bail',
                'required',
                'integer:strict',
                'min:' . self::MIN_LESSON_COUNT,
                'max:' . self::MAX_LESSON_COUNT,
            ],
        ];
    }
}
