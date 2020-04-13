<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Course;
use App\Models\Question;
use App\Models\Result;

class Lesson extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'course_id',
        'description',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
