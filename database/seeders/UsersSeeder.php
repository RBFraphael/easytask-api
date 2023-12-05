<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => "Admin",
            'last_name' => "Silva",
            'email' => "user@email.com",
            'password' => "123456",
            'role' => UserRole::ADMIN,
        ]);
    }
}
