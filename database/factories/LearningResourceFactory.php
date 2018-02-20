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
