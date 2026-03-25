<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $announcements = [
      [
        'title' => 'Jadwal Ujian Tengah Semester Genap 2025',
        'content' => "Dengan hormat, kami sampaikan jadwal Ujian Tengah Semester Genap tahun ajaran 2024/2025:\n\n📅 Tanggal: 3 - 7 Maret 2025\n📍 Lokasi: Ruang Kelas masing-masing\n\nHarap semua siswa hadir tepat waktu dan membawa perlengkapan ujian yang lengkap. Tidak ada toleransi keterlambatan.\n\nCatatan penting:\n- Bawa kartu ujian\n- Kenakan seragam lengkap\n- Matikan handphone selama ujian berlangsung\n\nTerima kasih atas perhatiannya.",
        'category' => 'akademik',
        'priority' => 'high',
        'author' => 'Kepala Sekolah',
        'date' => '2025-02-20',
        'is_active' => true,
      ],
      [
        'title' => 'Libur Nasional Hari Raya Nyepi',
        'content' => "Sehubungan dengan Hari Raya Nyepi, sekolah akan libur pada:\n\n📅 Tanggal: 29 Maret 2025\n\nSeluruh kegiatan belajar mengajar ditiadakan. Kegiatan akan dilanjutkan kembali pada hari Senin, 31 Maret 2025.\n\nSelamat merayakan Hari Raya Nyepi bagi yang menjalankan.",
        'category' => 'umum',
        'priority' => 'medium',
        'author' => 'Bagian Kurikulum',
        'date' => '2025-02-25',
        'is_active' => true,
      ],
      [
        'title' => 'Pendaftaran Lomba Karya Tulis Ilmiah',
        'content' => "Halo siswa-siswi berbakat! 🎉\n\nKami membuka pendaftaran untuk Lomba Karya Tulis Ilmiah tingkat provinsi. Bagi yang berminat, silakan daftarkan diri melalui wali kelas masing-masing.\n\n📅 Batas Pendaftaran: 15 Maret 2025\n🏆 Hadiah: Sertifikat + Uang Pembinaan\n\nSyarat:\n- Siswa aktif kelas 10-12\n- Memiliki KTI yang orisinil\n- Didampingi guru pembimbing\n\nAyo tunjukkan karya terbaikmu!",
        'category' => 'kegiatan',
        'priority' => 'low',
        'author' => 'OSIS SMKN 12',
        'date' => '2025-02-22',
        'is_active' => true,
      ],
      [
        'title' => 'Pemeliharaan Sistem Absensi',
        'content' => "Informasi penting untuk seluruh civitas akademika:\n\nSistem absensi akan dilakukan pemeliharaan pada:\n🗓️ Hari/Tanggal: Sabtu, 1 Maret 2025\n⏰ Waktu: 08.00 - 12.00 WIB\n\nSelama pemeliharaan, sistem absensi tidak dapat diakses. Mohon maaf atas ketidaknyamanannya.\n\nUntuk keperluan darurat, silakan hubungi bagian tata usaha.",
        'category' => 'umum',
        'priority' => 'high',
        'author' => 'Bagian IT',
        'date' => '2025-02-26',
        'is_active' => true,
      ],
      [
        'title' => 'Pengumuman Pemenang Lomba Debat Bahasa Inggris',
        'content' => "Selamat kepada para pemenang Lomba Debat Bahasa Inggris tingkat sekolah! 🏆\n\nJuara 1:\n- Kelompok A (Kelas 11 RPL 1)\n\nJuara 2:\n- Kelompok C (Kelas 12 TKJ 2)\n\nJuara 3:\n- Kelompok B (Kelas 10 Multimedia 1)\n\nPemenang akan mewakili sekolah dalam lomba tingkat provinsi. Latihan intensif akan dimulai minggu depan.\n\nSelamat dan semangat!",
        'category' => 'kegiatan',
        'priority' => 'medium',
        'author' => 'Tim Bahasa Inggris',
        'date' => '2025-02-24',
        'is_active' => true,
      ],
    ];

    foreach ($announcements as $announcement) {
      Announcement::create($announcement);
    }
  }
}
