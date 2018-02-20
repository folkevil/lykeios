<?php

use Faker\Generator as Faker;

$factory->define(App\Models\LearningResource::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'course_id' => function () {
            return factory(\App\Models\Course::class)->create()->id;
        },
    ];
});

$factory->state(App\Models\LearningResource::class, 'video', function (Faker $faker) {
    return [
        'resourceable_type' => \App\Models\VideoResource::class,
        'resourceable_id' => function () {
            return factory(\App\Models\VideoResource::class)->create()->id;
        },
    ];
});

$factory->state(App\Models\LearningResource::class, 'text', function (Faker $faker) {
    return [
        'resourceable_type' => \App\Models\TextResource::class,
        'resourceable_id' => function () {
            return factory(\App\Models\TextResource::class)->create()->id;
        },
    ];
});
