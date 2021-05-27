<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Medic;

/**
 * Run the database seeders.
 *
 * @return void
 */

use \Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{


    public function run()
    {
        Medic::factory()
            ->count(50)
            ->create();
    }
}
