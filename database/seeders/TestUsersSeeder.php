<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\OrangTua;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create Guru (Teacher) user
        $guru = Guru::where('email', 'guru@school.sch.id')->first();
        if (!$guru) {
            $guru = Guru::create([
                'id' => 100001,
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'guru@school.sch.id',
                'password' => 'guru123',
                'nip' => '198501152010011001',
            ]);
            $this->command->info('Guru user created successfully!');
            $this->command->info('Email: guru@school.sch.id');
            $this->command->info('NIP: 198501152010011001');
            $this->command->info('Password: guru123');
        } else {
            $this->command->info('Guru user already exists.');
        }

        // Create Siswa (Student) user
        $murid = Siswa::where('email', 'murid@school.sch.id')->first();
        if (!$murid) {
            $murid = Siswa::create([
                'id' => 200001,
                'name' => 'Ahmad Fauzi',
                'email' => 'murid@school.sch.id',
                'password' => 'murid123',
                'nis' => '200001',
                'nisn' => '0098765432',
                'class' => Siswa::CLASS_X,
                'jurusan' => Siswa::JURUSAN_MP,
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
        $ortu = OrangTua::where('email', 'ortu@school.sch.id')->first();
        if (!$ortu) {
            $ortu = OrangTua::create([
                'id' => 300001,
                'name' => 'Bapak Ahmad',
                'email' => 'ortu@school.sch.id',
                'password' => 'ortu123',
                'id_ortu' => 'ORTU001',
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
