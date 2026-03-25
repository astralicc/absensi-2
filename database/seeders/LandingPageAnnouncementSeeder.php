<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class LandingPageAnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'UTS (Ujian Tengah Semester)',
                'content' => 'UTS akan dimulai pada tanggal 9 Maret 2026. Mohon untuk seluruh siswa mempersiapkan diri dengan baik dan mengikuti jadwal ujian yang telah ditentukan. Pastikan membawa perlengkapan yang diperlukan.',
                'category' => 'Akademik',
                'priority' => 'high',
                'author' => 'Admin Sekolah',
                'date' => now(),
                'is_active' => true,
            ],
            [
                'title' => 'Libur Semester',
                'content' => 'Libur semester akan dimulai pada tanggal 15 Juni 2026. Seluruh siswa diharapkan mengumpulkan tugas dan menyelesaikan semua kewajiban akademik sebelum libur dimulai.',
                'category' => 'Umum',
                'priority' => 'medium',
                'author' => 'Admin Sekolah',
                'date' => now()->subDays(2),
                'is_active' => true,
            ],
            [
                'title' => 'Pemeliharaan Sistem Absensi',
                'content' => 'Sistem absensi akan dilakukan pemeliharaan rutin setiap hari Minggu pukul 00:00 - 04:00 WIB. Mohon maaf atas ketidaknyamanannya.',
                'category' => 'Kegiatan',
                'priority' => 'low',
                'author' => 'Tim IT',
                'date' => now()->subDays(5),
                'is_active' => true,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
