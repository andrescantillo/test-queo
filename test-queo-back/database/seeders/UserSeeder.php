<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$RRzXx.1vuH/FBAnFqGnDsOciay0rB3c9bVUJREjHAxhIjg5ZK/1my',
                'remember_token' => Str::random(10),
                'created_at' => '2023-02-04 10:00:00',
                'updated_at' => '2023-02-04 10:00:00'
             ]
        );
    }
}
