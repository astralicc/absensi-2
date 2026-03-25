<?php

namespace App\Http\Controllers;

use App\Exports\AdminSummaryExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminExportController extends Controller
{
    public function summary()
    {
        $name = 'laporan-ringkasan-'.now()->format('Y-m-d-His').'.xlsx';

        return Excel::download(new AdminSummaryExport(), $name);
    }
}
