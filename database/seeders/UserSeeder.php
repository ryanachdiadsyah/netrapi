<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'callsign' => 'JZ01CUV',
            'name' => 'Admin',
            'email' => 'achdiadsyah@gmail.com',
            'phone' => '081263280610',
            'password' => bcrypt('100200300'),
            'role' => 'admin',
        ]);

        User::create([
            'callsign' => 'JZ01ABB',
            'name' => 'Admin',
            'email' => 'rapibandaaceh@gmail.com',
            'phone' => '081263280610',
            'password' => bcrypt('100200300'),
            'role' => 'committee',
        ]);
    }
}
