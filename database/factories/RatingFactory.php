<?php

use Faker\Generator as Faker;

$factory->define(\App\Rating::class, function (Faker $faker) {
    return [
        'user_id' => \App\User::all()->random()->id,
        'product_id' => \App\Product::all()->random()->id,
        'rating' => rand(1,5),
        'comment' => $faker->paragraph,
    ];
});
