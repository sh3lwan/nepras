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
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Employee::class, function ($faker) {
    return [
        'name' => $faker->name,
        'contract_id' => rand(1, 2),
        'birth_date' => $faker->dateTime,
        'image' => 'image.jpg',
        'identity' => $faker->bankAccountNumber,
        'address' => $faker->address,
    ];
});

$factory->define(App\FamilyMember::class, function ($faker) {
    return [
        'name' => $faker->name,
        'birth_date' => $faker->dateTime,
        'relation' => $faker->word,
        'relative_id' => rand(1, 30),
    ];
});

$factory->define(App\Contract::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(50),
    ];
});
