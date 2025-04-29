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
 * @property string $language
 * @property int $time_seconds
 * @property int $speed_wpm
 * @property int $errors
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder<static>|TestResult newModelQuery()
 * @method static Builder<static>|TestResult newQuery()
 * @method static Builder<static>|TestResult query()
 * @method static Builder<static>|TestResult whereCreatedAt($value)
 * @method static Builder<static>|TestResult whereErrors($value)
 * @method static Builder<static>|TestResult whereId($value)
 * @method static Builder<static>|TestResult whereLanguage($value)
 * @method static Builder<static>|TestResult whereSpeedWpm($value)
 * @method static Builder<static>|TestResult whereTimeSeconds($value)
 * @method static Builder<static>|TestResult whereUpdatedAt($value)
 * @method static Builder<static>|TestResult whereUserId($value)
 */
class TestResult extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'language', 'time_seconds', 'speed_wpm', 'errors'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
