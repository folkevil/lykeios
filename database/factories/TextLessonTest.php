<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TextLesson::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
    ];
});
