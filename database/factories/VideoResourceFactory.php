<?php

use Faker\Generator as Faker;

$factory->define(App\Models\VideoResource::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
    ];
});
