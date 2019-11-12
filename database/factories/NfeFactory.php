<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\NfeSuccesses;
use Illuminate\Support\Str;

$factory->define(NfeSuccesses::class, function (Faker $faker) {
    return [
        'access_key' => Str::random(44),
        'amount' => $faker->randomFloat(2,1,900000),
        'xml' => $faker->imageUrl(),
    ];
});
