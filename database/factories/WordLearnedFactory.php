<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Word;
use App\Models\WordLearned;
use Faker\Generator as Faker;

$factory->define(WordLearned::class, function (Faker $faker) {
    return [
        'word_id' => Word::all()->random()->id,
        'user_id' => User::all()->random()->id,
    ];
});
