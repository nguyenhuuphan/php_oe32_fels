<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Course;
use App\Models\User;

class Word extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function wordLearned()
    {
        return $this->belongsToMany(User::class, 'word_learned');
    }
}
