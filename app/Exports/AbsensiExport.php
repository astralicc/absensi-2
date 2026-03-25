<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromCollection, WithHeadings, WithStyles
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return Attendance::whereMonth('date', $this->month)
            ->whereYear('date', $this->year)
            ->with('user')
            ->get()
            ->map(function ($a) {

                $status = $a->check_in ? 'Hadir' : 'Tidak Hadir';

                return [
                    'Nama' => $a->user->name ?? '',
                    'Kelas' => $a->user->class ?? '-', 
                    'Tanggal' => $a->date,
                    'Check In' => $a->check_in,
                    'Check Out' => $a->check_out,
                    'Status' => $status
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Kelas',
            'Tanggal',
            'Check In',
            'Check Out',
            'Status'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => 'FFFFD700']
                ]
            ]
        ];
    }
}