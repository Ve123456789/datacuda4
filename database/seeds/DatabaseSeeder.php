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
            Cities6TableSeeder::class,
            Cities7TableSeeder::class,
            Cities8TableSeeder::class,
            Cities9TableSeeder::class,
            Cities10TableSeeder::class,
            Cities11TableSeeder::class,
            Cities12TableSeeder::class,
            Cities13TableSeeder::class,
            Cities14TableSeeder::class,
            Cities15TableSeeder::class,
            Cities16TableSeeder::class,
            Cities17TableSeeder::class,
            Cities18TableSeeder::class,
            Cities19TableSeeder::class,
            Cities20TableSeeder::class,
            Cities21TableSeeder::class,
            Cities22TableSeeder::class,
            Cities23TableSeeder::class,
            Cities24TableSeeder::class,
            Cities25TableSeeder::class,
        ]);
    }
}
