<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $number
 * @property string $language
 * @property string $new_chars
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, LessonResult> $results
 * @property-read int|null $results_count
 * @property-read User $user
 * @method static Builder<static>|Lesson newModelQuery()
 * @method static Builder<static>|Lesson newQuery()
 * @method static Builder<static>|Lesson query()
 * @method static Builder<static>|Lesson whereCreatedAt($value)
 * @method static Builder<static>|Lesson whereId($value)
 * @method static Builder<static>|Lesson whereLanguage($value)
 * @method static Builder<static>|Lesson whereNewChars($value)
 * @method static Builder<static>|Lesson whereNumber($value)
 * @method static Builder<static>|Lesson whereUpdatedAt($value)
 * @method static Builder<static>|Lesson whereUserId($value)
 */
class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'number', 'total', 'language', 'new_chars', 'text'];

    public function results(): HasMany
    {
        return $this->hasMany(LessonResult::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
