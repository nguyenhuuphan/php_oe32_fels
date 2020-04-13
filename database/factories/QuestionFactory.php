<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Question;
use App\Models\Lesson;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'question' => $faker->sentence($nbWords = 6, $variableNbWords = true) . '?',
        'lesson_id' => Lesson::all()->random()->id,
    ];
});
