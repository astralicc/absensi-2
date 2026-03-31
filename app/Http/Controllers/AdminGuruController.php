<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminGuruController extends Controller
{
  public function index(Request $request)
  {
    $search = $request->query('search');

    $query = Guru::orderBy('name');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%")
          ->orWhere('phone', 'like', "%{$search}%");
      });
    }

    $gurus = $query->paginate(10);
    $totalGurus = Guru::count();
    $waliKelasCount = Guru::whereNotNull('kelas_wali')->count();
    $guruWithPhoneCount = Guru::whereNotNull('phone')->where('phone', '!=', '')->count();

    return view('admin.guru.index', compact('gurus', 'totalGurus', 'waliKelasCount', 'guruWithPhoneCount', 'search'));
  }

  public function create()
  {
    return view('admin.guru.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', 'unique:guru'],
      'phone' => ['nullable', 'string', 'max:20'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'kelas_wali' => ['nullable', Rule::in(['X', 'XI', 'XII'])],
      'jurusan_wali' => ['nullable', Rule::in(['RPL', 'BR', 'AKL', 'MP'])],
      'gender' => ['nullable', Rule::in(['L', 'P'])],
      'address' => ['nullable', 'string', 'max:500'],
      'birth_date' => ['nullable', 'date'],
    ]);

    Guru::create([
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'password' => Hash::make($request->password),
      'kelas_wali' => $request->kelas_wali,
      'jurusan_wali' => $request->jurusan_wali,
      'gender' => $request->gender,
      'address' => $request->address,
      'birth_date' => $request->birth_date,
    ]);

    return redirect()->route('admin.guru.index')
      ->with('success', 'Guru baru berhasil ditambahkan.');
  }

  public function edit(Guru $guru)
  {
    return view('admin.guru.edit', compact('guru'));
  }

  public function update(Request $request, Guru $guru)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', Rule::unique('guru')->ignore($guru->id)],
      'phone' => ['nullable', 'string', 'max:20'],
      'password' => ['nullable', 'string', 'min:8', 'confirmed'],
      'kelas_wali' => ['nullable', Rule::in(['X', 'XI', 'XII'])],
      'jurusan_wali' => ['nullable', Rule::in(['RPL', 'BR', 'AKL', 'MP'])],
      'gender' => ['nullable', Rule::in(['L', 'P'])],
      'address' => ['nullable', 'string', 'max:500'],
      'birth_date' => ['nullable', 'date'],
    ]);

    $updateData = [
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'kelas_wali' => $request->kelas_wali,
      'jurusan_wali' => $request->jurusan_wali,
      'gender' => $request->gender,
      'address' => $request->address,
      'birth_date' => $request->birth_date,
    ];

    if ($request->filled('password')) {
      $updateData['password'] = Hash::make($request->password);
    }

    $guru->update($updateData);

    return redirect()->route('admin.guru.index')
      ->with('success', 'Data guru berhasil diperbarui.');
  }

  public function destroy(Guru $guru)
  {
    $guru->delete();

    return redirect()->route('admin.guru.index')
      ->with('success', 'Data guru berhasil dihapus.');
  }
}
