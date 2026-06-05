<?php

namespace App\Http\Requests\Lesson;

use App\Http\Requests\BaseRequest;
use App\Models\Lesson;
use App\Rules\LanguageSupported;
use App\Traits\Constants\WithLessonConstants;

class LessonShowRequest extends BaseRequest
{
    use WithLessonConstants;

    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Lesson::class);
    }

    public function rules(): array
    {
        return [
            'language' => [new LanguageSupported()],
            'lesson_number' => [
                'bail',
                'integer',
                'min:' . self::MIN_LESSON_COUNT,
                'max:' . self::MAX_LESSON_COUNT,
            ],
        ];
    }

    public function validationData(): array
    {
        return [
            'language' => $this->route('language'),
            'lesson_number' => $this->route('lessonNumber'),
        ];
    }
}
