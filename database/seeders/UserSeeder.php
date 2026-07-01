<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id_level' => 1, // Administrator
            'name'     => 'Super Admin',
            'email'    => 'admin@laundry.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'id_level' => 2, // Operator
            'name'     => 'Operator',
            'email'    => 'operator@laundry.com',
            'password' => Hash::make('operator123'),
        ]);

        User::create([
            'id_level' => 3, // Pimpinan
            'name'     => 'Pimpinan',
            'email'    => 'pimpinan@laundry.com',
            'password' => Hash::make('pimpinan123'),
        ]);
    }
}
