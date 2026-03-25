<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            // Senin
            ['day' => 'Senin', 'subject' => 'Matematika', 'teacher' => 'Pak Budi Santoso', 'room' => 'Ruang 101', 'start_time' => '07:30', 'end_time' => '09:00', 'class' => 'X'],
            ['day' => 'Senin', 'subject' => 'Bahasa Indonesia', 'teacher' => 'Ibu Ani Wijaya', 'room' => 'Ruang 102', 'start_time' => '09:00', 'end_time' => '10:30', 'class' => 'X'],
            ['day' => 'Senin', 'subject' => 'IPA', 'teacher' => 'Pak Dedi Kurniawan', 'room' => 'Lab IPA', 'start_time' => '10:30', 'end_time' => '12:00', 'class' => 'X'],
            ['day' => 'Senin', 'subject' => 'Istirahat', 'teacher' => '-', 'room' => '-', 'start_time' => '12:00', 'end_time' => '13:00', 'class' => 'X'],
            ['day' => 'Senin', 'subject' => 'Bahasa Inggris', 'teacher' => 'Ibu Sarah Johnson', 'room' => 'Ruang 103', 'start_time' => '13:00', 'end_time' => '14:30', 'class' => 'X'],

            // Selasa
            ['day' => 'Selasa', 'subject' => 'PKN', 'teacher' => 'Pak Ahmad Sudirman', 'room' => 'Ruang 101', 'start_time' => '07:30', 'end_time' => '09:00', 'class' => 'X'],
            ['day' => 'Selasa', 'subject' => 'IPS', 'teacher' => 'Ibu Rina Marlina', 'room' => 'Ruang 102', 'start_time' => '09:00', 'end_time' => '10:30', 'class' => 'X'],
            ['day' => 'Selasa', 'subject' => 'Seni Budaya', 'teacher' => 'Ibu Maya Sari', 'room' => 'Ruang Seni', 'start_time' => '10:30', 'end_time' => '12:00', 'class' => 'X'],
            ['day' => 'Selasa', 'subject' => 'Istirahat', 'teacher' => '-', 'room' => '-', 'start_time' => '12:00', 'end_time' => '13:00', 'class' => 'X'],
            ['day' => 'Selasa', 'subject' => 'Olahraga', 'teacher' => 'Pak Joko Widodo', 'room' => 'Lapangan', 'start_time' => '13:00', 'end_time' => '14:30', 'class' => 'X'],

            // Rabu
            ['day' => 'Rabu', 'subject' => 'Matematika', 'teacher' => 'Pak Budi Santoso', 'room' => 'Ruang 101', 'start_time' => '07:30', 'end_time' => '09:00', 'class' => 'X'],
            ['day' => 'Rabu', 'subject' => 'Bahasa Indonesia', 'teacher' => 'Ibu Ani Wijaya', 'room' => 'Ruang 102', 'start_time' => '09:00', 'end_time' => '10:30', 'class' => 'X'],
            ['day' => 'Rabu', 'subject' => 'IPA', 'teacher' => 'Pak Dedi Kurniawan', 'room' => 'Lab IPA', 'start_time' => '10:30', 'end_time' => '12:00', 'class' => 'X'],
            ['day' => 'Rabu', 'subject' => 'Istirahat', 'teacher' => '-', 'room' => '-', 'start_time' => '12:00', 'end_time' => '13:00', 'class' => 'X'],
            ['day' => 'Rabu', 'subject' => 'Prakarya', 'teacher' => 'Pak Toni Hartono', 'room' => 'Bengkel', 'start_time' => '13:00', 'end_time' => '14:30', 'class' => 'X'],

            // Kamis
            ['day' => 'Kamis', 'subject' => 'Bahasa Inggris', 'teacher' => 'Ibu Sarah Johnson', 'room' => 'Ruang 103', 'start_time' => '07:30', 'end_time' => '09:00', 'class' => 'X'],
            ['day' => 'Kamis', 'subject' => 'IPS', 'teacher' => 'Ibu Rina Marlina', 'room' => 'Ruang 102', 'start_time' => '09:00', 'end_time' => '10:30', 'class' => 'X'],
            ['day' => 'Kamis', 'subject' => 'Matematika', 'teacher' => 'Pak Budi Santoso', 'room' => 'Ruang 101', 'start_time' => '10:30', 'end_time' => '12:00', 'class' => 'X'],
            ['day' => 'Kamis', 'subject' => 'Istirahat', 'teacher' => '-', 'room' => '-', 'start_time' => '12:00', 'end_time' => '13:00', 'class' => 'X'],
            ['day' => 'Kamis', 'subject' => 'Agama', 'teacher' => 'Ustadz Ahmad Fauzi', 'room' => 'Ruang 104', 'start_time' => '13:00', 'end_time' => '14:30', 'class' => 'X'],

            // Jumat
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
