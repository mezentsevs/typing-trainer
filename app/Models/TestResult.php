<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'language', 'speed_wpm', 'errors'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
