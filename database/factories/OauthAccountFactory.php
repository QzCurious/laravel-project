<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Eloquent\Auth\OauthAccount;
use App\Eloquent\Auth\User;
use Faker\Generator as Faker;

$factory->define(OauthAccount::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    return [
        'user_id' => $user,
        'sub' => $faker->uuid,
        'provider' => function () {
            throw new Exception('Attribute "provider" should be overrided.');
        },

    ];
});
