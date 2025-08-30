<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'alice@example.com'],
            [
                'name' => 'Alice',
                'username' => 'alice',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'bob@example.com'],
            [
                'name' => 'Bob',
                'username' => 'bob',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );
    }
}
