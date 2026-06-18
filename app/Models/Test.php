<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $language
 * @property string|null $genre
 * @property string $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Test newModelQuery()
 * @method static Builder<static>|Test newQuery()
 * @method static Builder<static>|Test query()
 * @method static Builder<static>|Test whereCreatedAt($value)
 * @method static Builder<static>|Test whereGenre($value)
 * @method static Builder<static>|Test whereId($value)
 * @method static Builder<static>|Test whereLanguage($value)
 * @method static Builder<static>|Test whereText($value)
 * @method static Builder<static>|Test whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Test extends Model
{
    use HasFactory;

    protected $fillable = ['language', 'genre', 'text'];
}
