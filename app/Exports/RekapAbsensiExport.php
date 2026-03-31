<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Siswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapAbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected string $dateFrom,
        protected string $dateTo,
        protected ?string $class,
        protected ?string $jurusan,
    ) {}

    public function collection(): Collection
    {
        $query = Attendance::query()
            ->with('user')
            ->whereBetween('date', [$this->dateFrom, $this->dateTo])
            ->orderBy('date')
            ->orderBy('user_id');

        if ($this->class) {
            $query->whereHas('user', fn ($q) => $q->where('class', $this->class));
        }
        if ($this->jurusan) {
            $query->whereHas('user', fn ($q) => $q->where('jurusan', $this->jurusan));
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['ID/NIS', 'Nama', 'Kelas', 'Jurusan', 'Tanggal', 'Masuk', 'Keluar', 'Status'];
    }

    /**
     * @param  Attendance  $row
     */
    public function map($row): array
    {
        $u = $row->user;
        $status = $row->check_in ? 'Hadir' : 'Tidak hadir';

        return [
            $u->id ?? '',
            $u->name ?? '',
            $u->class ?? '-',
            $u->jurusan ?? '-',
            $row->date->format('Y-m-d'),
            $row->check_in ? $row->check_in->format('H:i:s') : '-',
            $row->check_out ? $row->check_out->format('H:i:s') : '-',
            $status,
        ];
    }
}
