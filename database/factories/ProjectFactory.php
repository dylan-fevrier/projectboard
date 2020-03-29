<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => \Illuminate\Support\Str::limit($faker->paragraph, 200),
        'notes' => $faker->sentence,
        'owner_id' => function() {
            return factory(App\User::class)->create()->id;
        }
    ];
});
