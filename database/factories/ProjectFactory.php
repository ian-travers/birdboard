<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'notes' => $faker->paragraph(1),
        'owner_id' => function () {
            return factory(\App\User::class)->create()->id;
        }
    ];
});
