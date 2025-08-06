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
 * @method static Builder<static>|TestText newModelQuery()
 * @method static Builder<static>|TestText newQuery()
 * @method static Builder<static>|TestText query()
 * @method static Builder<static>|TestText whereCreatedAt($value)
 * @method static Builder<static>|TestText whereGenre($value)
 * @method static Builder<static>|TestText whereId($value)
 * @method static Builder<static>|TestText whereLanguage($value)
 * @method static Builder<static>|TestText whereText($value)
 * @method static Builder<static>|TestText whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TestText extends Model
{
    use HasFactory;

    protected $fillable = ['language', 'genre', 'text'];
}
