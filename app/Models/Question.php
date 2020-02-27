<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Lesson;
use App\Models\Answer;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'lesson_id',
        'answer_id',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
