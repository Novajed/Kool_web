<?php

use Faker\Generator as Faker;
use App\Grade;

$factory->define(App\Grade::class, function (Faker $faker) {
    return [
        'grade' => rand(1,13)
    ];
});
