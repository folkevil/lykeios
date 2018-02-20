<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TextResource::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
    ];
});
