<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Course;
use App\Models\Result;
use App\Models\Follower;
use App\Models\Activity;
use App\Models\Word;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->belongstoMany(Course::class, 'course_user', 'user_id', 'course_id')->withPivot('status')->withTimestamps();
    }

    public function learningCourse()
    {
        return $this->belongstoMany(Course::class, 'course_user', 'user_id', 'course_id')->wherePivot('status', false);;
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function followers()
    {
        return $this->hasMany(Follower::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function wordLearned()
    {
        return $this->belongsToMany(Word::class, 'word_learned');
    }
}
