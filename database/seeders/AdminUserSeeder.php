<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $existingAdmin = User::where('email', 'admin@school.sch.id')->first();
        
        if ($existingAdmin) {
            $this->command->info('Admin user already exists. Updating password...');
            
            // Update password to ensure it's correct
            $existingAdmin->update([
                'password' => Hash::make('admin123'),
                'role' => User::ROLE_ADMIN,
            ]);
            
            $this->command->info('Admin user updated successfully!');
            return;
        }

        // Create admin user with numeric ID
        $admin = User::create([
            'id' => 999999,
            'name' => 'Administrator',
            'email' => 'admin@school.sch.id',
            'password' => Hash::make('admin123'),
            'role' => User::ROLE_ADMIN,
        ]);


        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@school.sch.id');
        $this->command->info('Password: admin123');
    }
}
