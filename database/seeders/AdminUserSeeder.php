<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $existingAdmin = Admin::where('email', 'admin@school.sch.id')->first();
        
        if ($existingAdmin) {
            $this->command->info('Admin user already exists. Updating password...');
            $existingAdmin->update([
                'password' => 'admin123',
            ]);
            $this->command->info('Admin user updated successfully!');
            return;
        }

        Admin::create([
            'id' => 999999,
            'name' => 'Administrator',
            'email' => 'admin@school.sch.id',
            'password' => 'admin123',
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@school.sch.id');
        $this->command->info('Password: admin123');
    }
}
