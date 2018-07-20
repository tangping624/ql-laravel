<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $mobile;
    static $password;

    return [
        'mobile' => $mobile ?: $mobile = $faker->numberBetween(13000000000, 13900000000),
        'password' => $password ?: $password = bcrypt('abcdefg'),
        'nick_name' => $faker->name,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Admin::class, function (Faker\Generator $faker) {
    static $name;
    static $password;

    return [
        'name' => $name ?: $name = $faker->firstName,
        'password' => $password ?: $password = bcrypt('abcdefg'),
        'remember_token' => str_random(10),
    ];
});
