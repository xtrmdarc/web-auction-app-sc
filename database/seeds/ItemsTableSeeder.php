<?php

use App\Model\Item;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
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
            Item::create([
                'item_name' => $faker->unique()->word(),
                'end_date' => $faker->dateTimeBetween(now()->subYear(), now()->addYear()),
                'image' => $faker->imageUrl(400, 400, 'abstract'),
                'description' => $faker->realText(),
            ]);
        }
    }
}
