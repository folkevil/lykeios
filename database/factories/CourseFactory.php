<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Course::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'language' => 'en_US',
        'published_at' => null,
    ];
});

$factory->state(App\Models\Course::class, 'published', function (Faker $faker) {
    return [
        'published_at' => now(),
    ];
});
