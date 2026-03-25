<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Guru (Teacher) user
        $guru = User::where('email', 'guru@school.sch.id')->first();
        if (!$guru) {
            $guru = User::create([
                'id' => 100001,
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'guru@school.sch.id',
                'password' => Hash::make('guru123'),
                'role' => User::ROLE_GURU,
                'device_user_id' => '198501152010011001', // NIP
            ]);
            $this->command->info('Guru user created successfully!');
            $this->command->info('Email: guru@school.sch.id');
            $this->command->info('NIP: 198501152010011001');
            $this->command->info('Password: guru123');
        } else {
            $this->command->info('Guru user already exists.');
        }

        // Create Murid (Student) user
        $murid = User::where('email', 'murid@school.sch.id')->first();
        if (!$murid) {
            $murid = User::create([
                'id' => 200001,
                'name' => 'Ahmad Fauzi',
                'email' => 'murid@school.sch.id',
                'password' => Hash::make('murid123'),
                'role' => User::ROLE_MURID,
                'device_user_id' => '200001', // NIS
                'nisn' => '0098765432', // NISN
                'class' => User::CLASS_X,
                'jurusan' => User::JURUSAN_MP,
            ]);
            $this->command->info('Murid user created successfully!');
            $this->command->info('Email: murid@school.sch.id');
            $this->command->info('NIS: 200001');
            $this->command->info('NISN: 0098765432');
            $this->command->info('Password: murid123');
        } else {
            $this->command->info('Murid user already exists.');
        }

        // Create Orang Tua (Parent) user
        $ortu = User::where('email', 'ortu@school.sch.id')->first();
        if (!$ortu) {
            $ortu = User::create([
                'id' => 300001,
                'name' => 'Bapak Ahmad',
                'email' => 'ortu@school.sch.id',
                'password' => Hash::make('ortu123'),
                'role' => User::ROLE_ORANGTUA,
                'device_user_id' => 'ORTU001', // ID Orang Tua
            ]);
            $this->command->info('Orang Tua user created successfully!');
            $this->command->info('Email: ortu@school.sch.id');
            $this->command->info('ID Orang Tua: ORTU001');
            $this->command->info('Password: ortu123');
        } else {
            $this->command->info('Orang Tua user already exists.');
        }
    }
}
