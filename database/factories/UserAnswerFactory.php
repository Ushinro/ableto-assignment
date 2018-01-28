<?php

use Faker\Generator as Faker;

$factory->define(App\UserAnswer::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'question_choice_id' => function () {
            return factory(App\QuestionChoice::class)->create()->id;
        },
    ];
});
