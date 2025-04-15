<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'language', 'new_chars'];

    public function progresses()
    {
        return $this->hasMany(LessonProgress::class);
    }
}
