<?php

use Faker\Generator as Faker;

$factory->define(App\Access::class, function (Faker $faker) {
    $title = $faker->unique()->jobTitle;
    return [
        'title' => $title,
        'slug' => str_slug($title, '_'),
        'url' => $faker->url,
        'image' => $faker->word
    ];
});
