<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Lesson;
use App\Models\Course;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'description' => $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
        'course_id' => $faker->unique()->numberBetween($min = 1, $max = 6),
    ];
});
