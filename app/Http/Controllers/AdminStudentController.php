<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminStudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        $query = Siswa::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $query->orderBy($sortBy, $sortOrder);

        $students = $query->paginate(20);
        $totalStudents = Siswa::count();

        return view('admin.students.index', [
            'students' => $students,
            'totalStudents' => $totalStudents,
            'filters' => [
                'search' => $search,
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
            ],
        ]);
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:siswa,email',
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('siswa')->where(function ($query) {
                return $query->whereNotNull('nisn');
            })],
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'class' => ['required', Rule::in(Siswa::getClasses())],
            'jurusan' => ['required', Rule::in(Siswa::getJurusans())],
            'gender' => ['nullable', Rule::in(['L', 'P'])],
            'birth_date' => 'nullable|date',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Siswa::create($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit(Siswa $student)
    {
        return view('admin.students.edit', ['student' => $student]);
    }

    public function update(Request $request, Siswa $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('siswa')->ignore($student->id)],
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('siswa')->ignore($student->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'class' => ['required', Rule::in(Siswa::getClasses())],
            'jurusan' => ['required', Rule::in(Siswa::getJurusans())],
            'gender' => ['nullable', Rule::in(['L', 'P'])],
            'birth_date' => 'nullable|date',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $student->update($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Siswa $student)
    {
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}
