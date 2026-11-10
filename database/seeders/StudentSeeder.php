<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Student::create([
            'pin' => 'STU001',
            'full_name' => 'John Moyo',
            'programme' => 'BSc Computer Science',
            'zou_email' => 'john.moyo@zou.ac.zw',
            'phone' => '+263712345678',
            'centre_id' => 1,
            'status' => 'Active',
        ]);

        \App\Models\Student::create([
            'pin' => 'STU002',
            'full_name' => 'Sarah Chikwinya',
            'programme' => 'BSc Computer Science',
            'zou_email' => 'sarah.chikwinya@zou.ac.zw',
            'phone' => '+263712345679',
            'centre_id' => 1,
            'status' => 'Active',
        ]);

        \App\Models\Student::create([
            'pin' => 'STU003',
            'full_name' => 'Tendai Ndlovu',
            'programme' => 'BBA',
            'zou_email' => 'tendai.ndlovu@zou.ac.zw',
            'phone' => '+263712345680',
            'centre_id' => 2,
            'status' => 'Active',
        ]);
    }
}
