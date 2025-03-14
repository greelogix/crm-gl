<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('users')->insert([
        'name' => 'Muhammad Muzammal',
        'email' => 'm.muzammal@greelogix.com',
        'role' => 'admin',
        'password' => Hash::make('admin123'),
    ]);
    }
}
