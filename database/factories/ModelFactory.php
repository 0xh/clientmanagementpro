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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = 'secret',
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Employee::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = 'secret',
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Client::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = 'secret',
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Project::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Campaign::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Task::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence($nbWords = 15, $variableNbWords = true),
        'link' => $faker->url(),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Subtask::class, function (Faker\Generator $faker) {
    $done = array(true,false);
    return [
        'name' => $faker->name,
        'points' => $faker->numberBetween($min = 10, $max = 50),
        'priority' => $faker->numberBetween($min = 1, $max = 5),
        'link' => $faker->url(),
        'due_date' => \Carbon\Carbon::now()->addDays(10)->toDateTimeString(),
        'done'  => $faker->randomElement($done)
    ];
});

