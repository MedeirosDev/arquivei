<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Nfe;
use Illuminate\Support\Str;

$factory->define(Nfe::class, function (Faker $faker) {
    return [
        'access_key' => Str::random(44),
        'amount' => $faker->randomFloat(2,1,900000),
        'xml' => $faker->imageUrl(),
    ];
});
