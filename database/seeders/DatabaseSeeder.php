<?php

namespace Database\Seeders;

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
            RegionalCentreSeeder::class,
            ModuleSeeder::class,
            StudentSeeder::class,
            UserSeeder::class,
        ]);
    }
}
