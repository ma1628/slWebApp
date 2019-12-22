<?php

use Faker\Generator as Faker;

$factory->define(App\Slogan::class, function (Faker $faker) {

    $now = \Carbon\Carbon::now();
    return [
        'phrase' => $faker->realText(30),
        'writer' => $faker->name,
        'source' => $faker->streetName,
        'supplement' => $faker->realText(50),
        'rating' => $faker->randomFloat(1,1,5),
        'created_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
