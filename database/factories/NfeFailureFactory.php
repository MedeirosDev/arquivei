<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\NfeFailure;
use Illuminate\Support\Str;

$factory->define(NfeFailure::class, function (Faker $faker) {
    return [
        'access_key' => Str::random(44),
        'message' => $faker->paragraph(),
        'xml' => $faker->imageUrl(),
    ];
});
