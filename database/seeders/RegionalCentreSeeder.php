<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RegionalCentreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\RegionalCentre::create([
            'centre_name' => 'Harare Campus',
            'province' => 'Harare',
            'latitude' => -17.8292,
            'longitude' => 31.0522,
            'radius_m' => 100,
            'status' => 'Active',
        ]);

        \App\Models\RegionalCentre::create([
            'centre_name' => 'Bulawayo Campus',
            'province' => 'Bulawayo',
            'latitude' => -20.1500,
            'longitude' => 28.5833,
            'radius_m' => 100,
            'status' => 'Active',
        ]);

        \App\Models\RegionalCentre::create([
            'centre_name' => 'Mutare Campus',
            'province' => 'Manicaland',
            'latitude' => -18.9700,
            'longitude' => 32.6700,
            'radius_m' => 80,
            'status' => 'Active',
        ]);
    }
}
