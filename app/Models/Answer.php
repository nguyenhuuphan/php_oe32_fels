<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Question;

class Answer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer',
        'question_id',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
