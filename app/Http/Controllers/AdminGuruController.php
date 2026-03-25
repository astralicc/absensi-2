<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminGuruController extends Controller
{
  /**
   * Display list of all gurus (teachers)
   */
  public function index(Request $request)
  {
    $search = $request->query('search');

    $query = User::where('role', User::ROLE_GURU)
      ->orderBy('name');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%")
          ->orWhere('phone', 'like', "%{$search}%");
      });
    }

    $gurus = $query->paginate(10);
    $totalGurus = User::where('role', User::ROLE_GURU)->count();
    $waliKelasCount = User::where('role', User::ROLE_GURU)->whereNotNull('kelas_wali')->count();
    $guruWithPhoneCount = User::where('role', User::ROLE_GURU)->whereNotNull('phone')->where('phone', '!=', '')->count();

    return view('admin.guru.index', compact('gurus', 'totalGurus', 'waliKelasCount', 'guruWithPhoneCount', 'search'));
  }

  /**
   * Show create guru form
   */
  public function create()
  {
    return view('admin.guru.create');
  }

  /**
   * Store new guru
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', 'unique:users'],
      'phone' => ['nullable', 'string', 'max:20'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'kelas_wali' => ['nullable', Rule::in(['X', 'XI', 'XII'])],
      'jurusan_wali' => ['nullable', Rule::in(['RPL', 'BR', 'AKL', 'MP'])],
      'gender' => ['nullable', Rule::in(['L', 'P'])],
    ]);

    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'password' => Hash::make($request->password),
      'role' => User::ROLE_GURU,
      'kelas_wali' => $request->kelas_wali,
      'jurusan_wali' => $request->jurusan_wali,
      'gender' => $request->gender,
    ]);

    return redirect()->route('admin.guru.index')
      ->with('success', 'Guru baru berhasil ditambahkan.');
  }

  /**
   * Show edit guru form
   */
  public function edit(User $guru)
  {
    if ($guru->role !== User::ROLE_GURU) {
      return redirect()->route('admin.guru.index')
        ->with('error', 'Bukan data guru.');
    }

    return view('admin.guru.edit', compact('guru'));
  }

  /**
   * Update guru
   */
  public function update(Request $request, User $guru)
  {
    if ($guru->role !== User::ROLE_GURU) {
      return redirect()->route('admin.guru.index')
        ->with('error', 'Bukan data guru.');
    }

    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($guru->id)],
      'phone' => ['nullable', 'string', 'max:20'],
      'password' => ['nullable', 'string', 'min:8', 'confirmed'],
      'kelas_wali' => ['nullable', Rule::in(['X', 'XI', 'XII'])],
      'jurusan_wali' => ['nullable', Rule::in(['RPL', 'BR', 'AKL', 'MP'])],
      'gender' => ['nullable', Rule::in(['L', 'P'])],
    ]);

    $updateData = [
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'kelas_wali' => $request->kelas_wali,
      'jurusan_wali' => $request->jurusan_wali,
      'gender' => $request->gender,
    ];

    if ($request->filled('password')) {
      $updateData['password'] = Hash::make($request->password);
    }

    $guru->update($updateData);

    return redirect()->route('admin.guru.index')
      ->with('success', 'Data guru berhasil diperbarui.');
  }

  /**
   * Delete guru
   */
  public function destroy(User $guru)
  {
    if ($guru->role !== User::ROLE_GURU) {
      return redirect()->route('admin.guru.index')
        ->with('error', 'Bukan data guru.');
    }

    $guru->delete();

    return redirect()->route('admin.guru.index')
      ->with('success', 'Data guru berhasil dihapus.');
  }
}
