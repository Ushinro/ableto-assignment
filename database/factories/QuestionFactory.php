<?php

use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        'questionnaire_id' => function () {
            return factory(App\Questionnaire::class)->create()->id;
        },
        'label' => $faker->sentence,
        'type' => $faker->word,
    ];
});
