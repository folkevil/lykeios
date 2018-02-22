<?php

use Faker\Generator as Faker;

$factory->define(App\Models\VideoLesson::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
    ];
});
