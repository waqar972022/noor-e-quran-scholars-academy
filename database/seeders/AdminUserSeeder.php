<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@noor.test'],
            [
                'name' => 'Admin',
                'phone' => '03001234567',
                'password' => 'Admin@12345',
                'role' => 'admin',
                'account_status' => 'active',
            ]
        );
    }
}
