<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dwcu.edu.ph'],
            [
                'name'     => 'DWCU Admin',
                'email'    => 'admin@dwcu.edu.ph',
                'password' => Hash::make('admin1234'),
                'role'     => 'admin',
            ]
        );
    }
}
