<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Eloquent\Auth\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

// User without roles
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => 'password',
        'remember_token' => Str::random(10),
    ];
});

// Default role
$factory->afterMakingState(User::class, config('authflow.users.default_role'), function (User $user, Faker $faker) {
    $user->assignRole(config('authflow.users.default_role'));
});

// Admin role
$factory->afterMakingState(User::class, config('authflow.users.admin_role'), function (User $user, Faker $faker) {
    $user->assignRole(config('authflow.users.admin_role'));
});
