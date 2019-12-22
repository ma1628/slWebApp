<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {

    $now = \Carbon\Carbon::now();
    return [
        'contributor_name' => $faker->userName,
        'text' => $faker->realText(50),
        'rating' => $faker->numberBetween(1,5),
        'created_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
