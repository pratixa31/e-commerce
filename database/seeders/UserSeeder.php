<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@mailinator.com',
                'password' => Hash::make('user@'.$i),
                'is_admin' => 0,
            ]);
        }
    }
}
