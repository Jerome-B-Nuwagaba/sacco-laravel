<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a default admin user (optional)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Replace 'password' with a secure password
            'role' => 'admin',
        ]);

        // Create multiple customer users using the factory
        User::factory()->count(60)->customer()->create(); 

        // Create multiple loan officer users using the factory
        User::factory()->count(20)->loanOfficer()->create(); 

        
    }
}