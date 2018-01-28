<?php

use Faker\Generator as Faker;

$factory->define(App\QuestionChoice::class, function (Faker $faker) {
    return [
        'question_id' => function () {
            return factory(App\Question::class)->create()->id;
        },
        'label' => $faker->sentence,
        'value' => $faker->word,
    ];
});
