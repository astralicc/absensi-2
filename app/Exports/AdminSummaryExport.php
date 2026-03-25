<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\User;
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

        return collect([
            ['Total pengguna', User::count()],
            ['Murid', User::where('role', User::ROLE_MURID)->count()],
            ['Guru', User::where('role', User::ROLE_GURU)->count()],
            ['Orang tua', User::where('role', User::ROLE_ORANGTUA)->count()],
            ['Administrator', User::where('role', User::ROLE_ADMIN)->count()],
            ['Rekaman absensi (bulan berjalan)', $attMonth],
        ]);
    }

    public function headings(): array
    {
        return ['Metrik', 'Nilai'];
    }
}
