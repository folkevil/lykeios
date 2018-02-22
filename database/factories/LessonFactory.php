<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Lesson::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'course_id' => function () {
            return factory(\App\Models\Course::class)->create()->id;
        },
    ];
});

$factory->state(App\Models\Lesson::class, 'video', function (Faker $faker) {
    return [
        'lessonable_type' => \App\Models\VideoLesson::class,
        'lessonable_id' => function () {
            return factory(\App\Models\VideoLesson::class)->create()->id;
        },
    ];
});

$factory->state(App\Models\Lesson::class, 'text', function (Faker $faker) {
    return [
        'lessonable_type' => \App\Models\TextLesson::class,
        'lessonable_id' => function () {
            return factory(\App\Models\TextLesson::class)->create()->id;
        },
    ];
});
