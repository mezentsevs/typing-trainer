<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $lesson_id
 * @property string $language
 * @property int $time_seconds
 * @property int $speed_wpm
 * @property int $errors
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Lesson $lesson
 * @property-read User $user
 * @method static Builder<static>|LessonProgress newModelQuery()
 * @method static Builder<static>|LessonProgress newQuery()
 * @method static Builder<static>|LessonProgress query()
 * @method static Builder<static>|LessonProgress whereCreatedAt($value)
 * @method static Builder<static>|LessonProgress whereErrors($value)
 * @method static Builder<static>|LessonProgress whereId($value)
 * @method static Builder<static>|LessonProgress whereLanguage($value)
 * @method static Builder<static>|LessonProgress whereLessonId($value)
 * @method static Builder<static>|LessonProgress whereSpeedWpm($value)
 * @method static Builder<static>|LessonProgress whereTimeSeconds($value)
 * @method static Builder<static>|LessonProgress whereUpdatedAt($value)
 * @method static Builder<static>|LessonProgress whereUserId($value)
 */
class LessonProgress extends Model
{
    use HasFactory;

    protected $table = 'lesson_progresses';

    protected $fillable = ['user_id', 'lesson_id', 'language', 'time_seconds', 'speed_wpm', 'errors'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
