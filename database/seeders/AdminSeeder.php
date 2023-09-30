<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        \App\Models\User::create([
            'name' => 'Test Admin',
            'email' => 'testadmin@mailinator.com',
            'password' => Hash::make('testadmin'),
            'is_admin' => 1,
        ]);
    }
}
