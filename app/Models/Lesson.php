<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'number', 'language', 'new_chars'];

    public function progresses()
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
