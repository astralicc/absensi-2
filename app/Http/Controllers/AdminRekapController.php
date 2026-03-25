<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class AdminRekapController extends Controller
{
  public function index(Request $request)
  {
    $dateFrom = $request->get('date_from', now()->toDateString());
    $dateTo = $request->get('date_to', now()->toDateString());

    // NOTE: in the view, the field name is `class`
    $kelas = $request->get('class');
    // The Blade view uses `$class` for the selected option
    $class = $kelas;
    $jurusan = $request->get('jurusan');

    $query = Attendance::with('user');

    if ($kelas) {
      $query->whereHas('user', fn($q) => $q->where('class', $kelas));
    }

    if ($jurusan) {
      $query->whereHas('user', fn($q) => $q->where('jurusan', $jurusan));
    }

    // Apply date range filters on `attendances.date`
    if (!empty($dateFrom) && !empty($dateTo)) {
      $query->whereBetween('date', [$dateFrom, $dateTo]);
    } elseif (!empty($dateFrom)) {
      $query->whereDate('date', '>=', $dateFrom);
    } elseif (!empty($dateTo)) {
      $query->whereDate('date', '<=', $dateTo);
    }

    // Filter dropdown lists
    $kelasList = User::where('role', User::ROLE_MURID)
      ->when(!empty($jurusan), fn($q) => $q->where('jurusan', $jurusan))
      ->distinct()
      ->pluck('class')
      ->filter()
      ->values()
      ->sort()
      ->toArray();

    $jurusanList = User::where('role', User::ROLE_MURID)
      ->when(!empty($kelas), fn($q) => $q->where('class', $kelas))
      ->distinct()
      ->pluck('jurusan')
      ->filter()
      ->values()
      ->sort()
      ->toArray();

    // Used by the "Total baris (filter)" counter in the view
    $totalRecords = (clone $query)->count();

    $rekaps = $query->paginate(50);

    $totalHadir = Attendance::whereNotNull('check_in')
      ->whereTime('check_in', '<=', '07:00:00')
      ->count();

    $totalTelat = Attendance::whereNotNull('check_in')
      ->whereTime('check_in', '>', '07:00:00')
      ->count();

    $totalAlpha = Attendance::whereNull('check_in')->count();

    return view('admin.rekap.index', compact(
      'rekaps',
      'kelas',
      'jurusan',
      'class',
      'dateFrom',
      'dateTo',
      'kelasList',
      'jurusanList',
      'totalRecords',
      'totalHadir',
      'totalTelat',
      'totalAlpha'
    ));
  }

  public function export(Request $request)
  {
    // AbsensiExport currently expects a single month/year.
    // Use `date_from` if present, otherwise fallback to current month/year.
    $dateFrom = $request->get('date_from');
    $month = now()->month;
    $year = now()->year;

    if (!empty($dateFrom)) {
      $parsed = Carbon::parse($dateFrom);
      $month = $parsed->month;
      $year = $parsed->year;
    }

    return Excel::download(new AbsensiExport($month, $year), 'rekap-absensi.xlsx');
  }
}
