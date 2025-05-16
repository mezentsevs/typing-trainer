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
 * @method static Builder<static>|LessonResult newModelQuery()
 * @method static Builder<static>|LessonResult newQuery()
 * @method static Builder<static>|LessonResult query()
 * @method static Builder<static>|LessonResult whereCreatedAt($value)
 * @method static Builder<static>|LessonResult whereErrors($value)
 * @method static Builder<static>|LessonResult whereId($value)
 * @method static Builder<static>|LessonResult whereLanguage($value)
 * @method static Builder<static>|LessonResult whereLessonId($value)
 * @method static Builder<static>|LessonResult whereSpeedWpm($value)
 * @method static Builder<static>|LessonResult whereTimeSeconds($value)
 * @method static Builder<static>|LessonResult whereUpdatedAt($value)
 * @method static Builder<static>|LessonResult whereUserId($value)
 */
class LessonResult extends Model
{
    use HasFactory;

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
