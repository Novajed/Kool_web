<?php

use App\Song;
use Faker\Generator as Faker;

$factory->define(Song::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'subject_id' => rand(1,4),
    ];
});
