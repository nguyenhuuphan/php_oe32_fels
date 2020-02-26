<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Course;
use App\Models\Result;
use App\Models\Follower;
use App\Models\Activity;
use App\Models\WordLearned;

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
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
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

    public function course()
    {
        return $this->hasOne(Course::class);
    }

    public function result()
    {
        return $this->hasOne(Result::class);
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
        return $this->hasMany(WordLearned::class);
    }
}
