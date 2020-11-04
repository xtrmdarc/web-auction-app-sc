<?php

use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for($i = 0; $i < 100; $i++)
        {
            User::create([
                'name' => $faker->unique()->name,
                'password' => $faker->password(),
                'username' => $faker->userName,
                'max_auto_bid_amount' => $faker->randomFloat(2, 0, 300),
            ]);
        }
    }
}
