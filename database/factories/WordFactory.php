<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Word;
use App\Models\Course;
use Faker\Generator as Faker;

$factory->define(Word::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'course_id' => Course::all()->random()->id,
    ];
});
