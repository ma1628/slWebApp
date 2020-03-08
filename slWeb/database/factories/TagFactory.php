<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {

    $now = \Carbon\Carbon::now();
    return [
        'tag_name' => $faker->realText(10),
//        'tag_kana' => $faker->shuffle('namenamenamenamef'),
        'created_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
