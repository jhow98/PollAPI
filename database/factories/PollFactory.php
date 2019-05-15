<?php

use Faker\Generator as Faker;

$factory->define(\Api\Poll::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->randomFloat(0, 0, 8),
        'description' => $faker->text
    ];
});
