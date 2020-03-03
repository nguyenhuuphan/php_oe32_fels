<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Word;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function words()
    {
        return $this->hasMany(Word::class);
    }

    public function lesson()
    {
        return $this->hasOne(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
