<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Concerns\GeneratesPasswords;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    use GeneratesPasswords;

    public function run(): void
    {
        $password = $this->randomPassword();

        User::updateOrCreate(
            ['email' => 'admin@dwcu.edu.ph'],
            [
                'name'     => 'DWCU Admin',
                'email'    => 'admin@dwcu.edu.ph',
                'password' => Hash::make($password),
                'role'     => 'admin',
            ]
        );

        $this->logCredential('Admin', 'DWCU Admin', 'admin@dwcu.edu.ph', $password);
    }
}
