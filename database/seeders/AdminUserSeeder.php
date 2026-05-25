<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public const EMAIL = 'admin@hometix.test';
    public const PASSWORD = 'Hometix@123456';

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => self::EMAIL],
            [
                'name' => 'HOMETIX Admin',
                'password' => Hash::make(self::PASSWORD),
                'is_admin' => true,
            ]
        );
    }
}

