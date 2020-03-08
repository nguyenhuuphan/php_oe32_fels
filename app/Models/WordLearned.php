<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordLearned extends Model
{
    protected $table = 'word_learned';
    protected $fillable = [
        'user_id',
        'word_id',
    ];
}
