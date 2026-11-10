<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Module::create([
            'module_code' => 'CS101',
            'module_name' => 'Introduction to Computer Science',
            'programme' => 'BSc Computer Science',
        ]);

        \App\Models\Module::create([
            'module_code' => 'MATH201',
            'module_name' => 'Calculus II',
            'programme' => 'BSc Mathematics',
        ]);

        \App\Models\Module::create([
            'module_code' => 'BUS301',
            'module_name' => 'Business Management',
            'programme' => 'BBA',
        ]);
    }
}
