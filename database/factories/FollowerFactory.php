<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Follower;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Follower::class, function (Faker $faker) {
    $user_id = User::all()->random()->id;
    return [
        'user_id' => $user_id,
        'follower_id' => uniqueId($user_id),
    ];
});

function uniqueId($user_id)
{
    $follower_id = User::all()->random()->id;
    while ($user_id === $follower_id) {
        $follower_id = User::all()->random()->id;
    }
    return $follower_id;
}
