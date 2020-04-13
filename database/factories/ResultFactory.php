<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Result;
use App\Models\Course;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Result::class, function (Faker $faker) {
    return [
        'result' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10),
        'user_id' => $faker->unique()->randomElement(User::pluck('id', 'id')->toArray()),
        'course_id' => Course::all()->random()->id,
    ];
});
