<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Gallery::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->text(200),
        'user_id' => $faker->numberBetween($min = 1, $max = 5)
    ];
});
