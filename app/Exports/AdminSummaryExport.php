<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\OrangTua;
use App\Models\Admin;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminSummaryExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        $now = now();
        $attMonth = Attendance::query()
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->count();

        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalOrtu = OrangTua::count();
        $totalAdmin = Admin::count();

        return collect([
            ['Total pengguna', $totalSiswa + $totalGuru + $totalOrtu + $totalAdmin],
            ['Murid', $totalSiswa],
            ['Guru', $totalGuru],
            ['Orang tua', $totalOrtu],
            ['Administrator', $totalAdmin],
            ['Rekaman absensi (bulan berjalan)', $attMonth],
        ]);
    }

    public function headings(): array
    {
        return ['Metrik', 'Nilai'];
    }
}
