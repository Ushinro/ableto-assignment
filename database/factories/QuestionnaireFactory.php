<?php

use Faker\Generator as Faker;

$factory->define(App\Questionnaire::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
