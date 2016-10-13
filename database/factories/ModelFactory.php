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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->unique()->username,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Journal::class, function (Faker\Generator $faker) {
    return [
        'publish_date' => $faker->dateTimeThisYear,
        'contents' => $faker->paragraphs(5, true),
        'events' => $faker->sentences(3, true),
        'user_id' => function () {
            return App\User::inRandomOrder()->first()->id;
        },
    ];
});
