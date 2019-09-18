<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountriesTableSeeder::class,
            CitiesTableSeeder::class,
            Cities1TableSeeder::class,
            Cities2TableSeeder::class,
            Cities3TableSeeder::class,
            Cities4TableSeeder::class,
            Cities5TableSeeder::class,
            Cities6TableSeeder::class
        ]);
    }
}
