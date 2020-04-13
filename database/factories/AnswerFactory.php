<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Answer;
use App\Models\Question;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'answer' => $faker->sentence($nbWords = 10, $variableNbWords = true),
        'question_id' => Question::all()->random()->id,
    ];
});
