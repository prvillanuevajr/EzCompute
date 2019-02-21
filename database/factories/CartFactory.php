<?php

use Faker\Generator as Faker;

$factory->define(App\Cart::class, function (Faker $faker) {
    return [
        'user_id' => \App\User::where('is_admin', null)->get()->random()->id,
        'product_id' => \App\Product::all()->random()->id,
        'quantity' => rand(1, 10),
    ];
});
