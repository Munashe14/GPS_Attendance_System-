<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Student user
        \App\Models\User::firstOrCreate([
            'username' => 'student',
        ], [
            'password' => bcrypt('password'),
            'role' => 'Student',
            'linked_id' => 1,
            'status' => 'Active',
        ]);

        // Lecturer user
        \App\Models\User::firstOrCreate([
            'username' => 'lecturer',
        ], [
            'password' => bcrypt('password'),
            'role' => 'Lecturer',
            'linked_id' => null,
            'status' => 'Active',
        ]);

        // Regional Admin user
        \App\Models\User::firstOrCreate([
            'username' => 'regional_admin',
        ], [
            'password' => bcrypt('password'),
            'role' => 'RegionalAdmin',
            'linked_id' => null,
            'status' => 'Active',
        ]);

        // System Admin user
        \App\Models\User::firstOrCreate([
            'username' => 'admin',
        ], [
            'password' => bcrypt('password'),
            'role' => 'SysAdmin',
            'linked_id' => null,
            'status' => 'Active',
        ]);
    }
}
