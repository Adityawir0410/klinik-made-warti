<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Klinik',
                'email' => 'admin@klinik.com',
                'password' => Hash::make('password'), // jangan lupa login pakai ini
                'id_role' => 1 // Super Admin
            ],
            [
                'name' => 'Bidan Made',
                'email' => 'bidan@klinik.com',
                'password' => Hash::make('password'),
                'id_role' => 2 // Bidan
            ]
        ]);
    }
}
