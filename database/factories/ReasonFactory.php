<?php

use Faker\Generator as Faker;

$factory->define(App\Reason::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->jobTitle,
        'description' => $faker->text,
        'color' => $faker->safeColorName,
        'hex_color' => $faker->hexColor,
        'has_to_confirm' => $faker->boolean,
    ];
});
