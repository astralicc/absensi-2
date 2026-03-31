<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Guru;
use App\Models\OrangTua;
use App\Models\Schedule;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Orang Tua (Parent)
        $ortu = OrangTua::create([
            'id' => 11111,
            'name' => 'mamah',
            'email' => 'ortu@example.com',
            'password' => 'password123',
            'id_ortu' => '11111',
        ]);

        // Create Siswa (Students)
        $murid = Siswa::create([
            'id' => 12345,
            'name' => 'Watsiq Afina Nuraini',
            'email' => 'murid@example.com',
            'password' => 'password123',
            'nis' => '12345',
            'nisn' => '0091234567',
            'parent_id' => $ortu->id,
            'class' => Siswa::CLASS_X,
            'jurusan' => Siswa::JURUSAN_RPL,
        ]);

        $murid2 = Siswa::create([
            'id' => 12346,
            'name' => 'Ibnu Abi Ad-Dunya',
            'email' => 'murid2@example.com',
            'password' => 'password123',
            'nis' => '12346',
            'nisn' => '0091234568',
            'parent_id' => null,
            'class' => Siswa::CLASS_XI,
            'jurusan' => Siswa::JURUSAN_BR,
        ]);

        $murid3 = Siswa::create([
            'id' => 12347,
            'name' => 'Reza Aditya Shaputra',
            'email' => 'murid3@example.com',
            'password' => 'password123',
            'nis' => '12347',
            'nisn' => '0091234569',
            'parent_id' => null,
            'class' => Siswa::CLASS_XII,
            'jurusan' => Siswa::JURUSAN_AKL,
        ]);

        // Create Guru (Teacher)
        $guru = Guru::create([
            'id' => 98765,
            'name' => 'Irwan Saputra',
            'email' => 'guru@example.com',
            'password' => 'password123',
            'nip' => '98765',
        ]);

        // Create sample attendance data
        $this->createSampleAttendances($murid);
        $this->createSampleAttendances($murid2);

        // Create sample schedule data
        $this->createSampleSchedules();

        // Create admin user
        $this->call(AdminUserSeeder::class);

        // Create sample announcements
        $this->call(AnnouncementSeeder::class);

        $this->command->info('Test users created successfully!');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('==================');
        $this->command->info('Murid     : NIS=12345 / NISN=0091234567, Password=password123');
        $this->command->info('Murid 2   : NIS=12346 / NISN=0091234568, Password=password123');
        $this->command->info('Murid 3   : NIS=12347 / NISN=0091234569, Password=password123');
        $this->command->info('Guru      : NIP=98765, Password=password123');
        $this->command->info('Orang Tua : ID=11111, Password=password123');
        $this->command->info('');
        $this->command->info('Parent-Child Relationship:');
        $this->command->info('mamah (11111) is parent of Watsiq Afina Nuraini (12345)');
    }

    private function createSampleAttendances(Siswa $student): void
    {
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);

            if ($date->isWeekend()) {
                continue;
            }

            $isPresent = rand(1, 100) <= 80;

            Attendance::create([
                'user_id' => $student->id,
                'date' => $date->format('Y-m-d'),
                'check_in' => $isPresent ? $date->copy()->setTime(7, rand(0, 30)) : null,
                'check_out' => $isPresent ? $date->copy()->setTime(15, rand(0, 30)) : null,
            ]);
        }
    }

    private function createSampleSchedules(): void
    {
        $schedules = [
            ['day' => 'Senin', 'subject' => 'Matematika', 'teacher' => 'Pak Budi Santoso', 'room' => 'Ruang 101', 'start_time' => '07:30', 'end_time' => '09:00', 'class' => 'X'],
            ['day' => 'Senin', 'subject' => 'Bahasa Indonesia', 'teacher' => 'Ibu Ani Wijaya', 'room' => 'Ruang 102', 'start_time' => '09:00', 'end_time' => '10:30', 'class' => 'X'],
            ['day' => 'Senin', 'subject' => 'IPA', 'teacher' => 'Pak Dedi Kurniawan', 'room' => 'Lab IPA', 'start_time' => '10:30', 'end_time' => '12:00', 'class' => 'X'],
            ['day' => 'Senin', 'subject' => 'Istirahat', 'teacher' => '-', 'room' => '-', 'start_time' => '12:00', 'end_time' => '13:00', 'class' => 'X'],
            ['day' => 'Senin', 'subject' => 'Bahasa Inggris', 'teacher' => 'Ibu Sarah Johnson', 'room' => 'Ruang 103', 'start_time' => '13:00', 'end_time' => '14:30', 'class' => 'X'],
            ['day' => 'Selasa', 'subject' => 'PKN', 'teacher' => 'Pak Ahmad Sudirman', 'room' => 'Ruang 101', 'start_time' => '07:30', 'end_time' => '09:00', 'class' => 'X'],
            ['day' => 'Selasa', 'subject' => 'IPS', 'teacher' => 'Ibu Rina Marlina', 'room' => 'Ruang 102', 'start_time' => '09:00', 'end_time' => '10:30', 'class' => 'X'],
            ['day' => 'Selasa', 'subject' => 'Seni Budaya', 'teacher' => 'Ibu Maya Sari', 'room' => 'Ruang Seni', 'start_time' => '10:30', 'end_time' => '12:00', 'class' => 'X'],
            ['day' => 'Selasa', 'subject' => 'Istirahat', 'teacher' => '-', 'room' => '-', 'start_time' => '12:00', 'end_time' => '13:00', 'class' => 'X'],
            ['day' => 'Selasa', 'subject' => 'Olahraga', 'teacher' => 'Pak Joko Widodo', 'room' => 'Lapangan', 'start_time' => '13:00', 'end_time' => '14:30', 'class' => 'X'],
            ['day' => 'Rabu', 'subject' => 'Matematika', 'teacher' => 'Pak Budi Santoso', 'room' => 'Ruang 101', 'start_time' => '07:30', 'end_time' => '09:00', 'class' => 'X'],
            ['day' => 'Rabu', 'subject' => 'Bahasa Indonesia', 'teacher' => 'Ibu Ani Wijaya', 'room' => 'Ruang 102', 'start_time' => '09:00', 'end_time' => '10:30', 'class' => 'X'],
            ['day' => 'Rabu', 'subject' => 'IPA', 'teacher' => 'Pak Dedi Kurniawan', 'room' => 'Lab IPA', 'start_time' => '10:30', 'end_time' => '12:00', 'class' => 'X'],
            ['day' => 'Rabu', 'subject' => 'Istirahat', 'teacher' => '-', 'room' => '-', 'start_time' => '12:00', 'end_time' => '13:00', 'class' => 'X'],
            ['day' => 'Rabu', 'subject' => 'Prakarya', 'teacher' => 'Pak Toni Hartono', 'room' => 'Bengkel', 'start_time' => '13:00', 'end_time' => '14:30', 'class' => 'X'],
            ['day' => 'Kamis', 'subject' => 'Bahasa Inggris', 'teacher' => 'Ibu Sarah Johnson', 'room' => 'Ruang 103', 'start_time' => '07:30', 'end_time' => '09:00', 'class' => 'X'],
            ['day' => 'Kamis', 'subject' => 'IPS', 'teacher' => 'Ibu Rina Marlina', 'room' => 'Ruang 102', 'start_time' => '09:00', 'end_time' => '10:30', 'class' => 'X'],
            ['day' => 'Kamis', 'subject' => 'Matematika', 'teacher' => 'Pak Budi Santoso', 'room' => 'Ruang 101', 'start_time' => '10:30', 'end_time' => '12:00', 'class' => 'X'],
            ['day' => 'Kamis', 'subject' => 'Istirahat', 'teacher' => '-', 'room' => '-', 'start_time' => '12:00', 'end_time' => '13:00', 'class' => 'X'],
            ['day' => 'Kamis', 'subject' => 'Agama', 'teacher' => 'Ustadz Ahmad Fauzi', 'room' => 'Ruang 104', 'start_time' => '13:00', 'end_time' => '14:30', 'class' => 'X'],
            ['day' => 'Jumat', 'subject' => 'Bahasa Indonesia', 'teacher' => 'Ibu Ani Wijaya', 'room' => 'Ruang 102', 'start_time' => '07:30', 'end_time' => '09:00', 'class' => 'X'],
            ['day' => 'Jumat', 'subject' => 'IPA', 'teacher' => 'Pak Dedi Kurniawan', 'room' => 'Lab IPA', 'start_time' => '09:00', 'end_time' => '10:30', 'class' => 'X'],
            ['day' => 'Jumat', 'subject' => 'PKN', 'teacher' => 'Pak Ahmad Sudirman', 'room' => 'Ruang 101', 'start_time' => '10:30', 'end_time' => '12:00', 'class' => 'X'],
            ['day' => 'Jumat', 'subject' => 'Jumat Berkah', 'teacher' => '-', 'room' => 'Masjid', 'start_time' => '12:00', 'end_time' => '13:30', 'class' => 'X'],
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }

        $this->command->info('Sample schedules created successfully!');
    }
}
