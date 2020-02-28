<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Activity;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'activity' => $faker->randomElement($array = array (
            'follows ' . User::all()->random()->name,
            'starts a Course ' . Course::all()->random()->name,
            'takes a lesson ' . Lesson::all()->random()->name,
        )),
    ];
});
