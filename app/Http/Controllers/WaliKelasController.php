<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class WaliKelasController extends Controller
{
    /**
     * Display list of teachers (guru) that can be assigned as wali kelas
     */
    public function index()
    {
        $gurus = Guru::orderBy('name')->get();
        $totalStudents = Siswa::count();

        return view('admin.wali-kelas.index', compact('gurus', 'totalStudents'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.wali-kelas.edit', compact('guru'));
    }

    /**
     * Update kelas_wali and jurusan_wali for a guru
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'kelas_wali' => ['nullable', Rule::in(['X', 'XI', 'XII'])],
            'jurusan_wali' => ['nullable', Rule::in(['RPL', 'BR', 'AKL', 'MP'])],
        ]);

        $guru->update([
            'kelas_wali' => $request->kelas_wali,
            'jurusan_wali' => $request->jurusan_wali,
        ]);

        return redirect()->route('admin.wali-kelas.index')
            ->with('success', 'Wali kelas berhasil diperbarui.');
    }

    /**
     * Remove kelas_wali and jurusan_wali from a guru
     */
    public function destroy(Guru $guru)
    {
        $guru->update([
            'kelas_wali' => null,
            'jurusan_wali' => null,
        ]);

        return redirect()->route('admin.wali-kelas.index')
            ->with('success', 'Wali kelas berhasil dihapus.');
    }

    /**
     * Wali Kelas Dashboard
     */
    public function waliDashboard()
    {
        $user = Auth::guard('guru')->user();

        $query = Siswa::where('class', $user->kelas_wali);
        if ($user->jurusan_wali) {
            $query->where('jurusan', $user->jurusan_wali);
        }
        $students = $query->orderBy('name')->get();
        $totalStudents = $students->count();

        $studentIds = $students->pluck('id');
        $todayAttendances = \App\Models\Attendance::where('date', today())
            ->whereIn('user_id', $studentIds)
            ->with('siswa')
            ->orderBy('check_in', 'desc')
            ->get();

        $presentToday = $todayAttendances->whereNotNull('check_in')->count();
        $absentToday = $totalStudents - $presentToday;

        $unreadCount = $user->unreadAnnouncementsCount();

        return view('wali-kelas.index', compact('user', 'students', 'totalStudents', 'todayAttendances', 'presentToday', 'absentToday', 'unreadCount'));
    }
}
