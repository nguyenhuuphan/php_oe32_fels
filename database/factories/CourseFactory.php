<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'description' => $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
        'image' => $faker->imageUrl($width = 640, $height = 480),
    ];
});
