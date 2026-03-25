<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminStudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        $query = User::where('role', User::ROLE_MURID);

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortOrder);

        $students = $query->paginate(20);
        $totalStudents = User::where('role', User::ROLE_MURID)->count();

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

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('users')->where(function ($query) {
                return $query->whereNotNull('nisn');
            })],
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'class' => ['required', Rule::in(User::getClasses())],
            'jurusan' => ['required', Rule::in(User::getJurusans())],
            'gender' => ['nullable', Rule::in(['L', 'P'])],
            'birth_date' => 'nullable|date',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = User::ROLE_MURID;

        User::create($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(User $student)
    {
        // Ensure we're editing a student
        if ($student->role !== User::ROLE_MURID) {
            return redirect()->route('admin.students.index')
                ->with('error', 'User bukan siswa');
        }

        return view('admin.students.edit', [
            'student' => $student,
        ]);
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, User $student)
    {
        // Ensure we're updating a student
        if ($student->role !== User::ROLE_MURID) {
            return redirect()->route('admin.students.index')
                ->with('error', 'User bukan siswa');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($student->id)],
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($student->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'class' => ['required', Rule::in(User::getClasses())],
            'jurusan' => ['required', Rule::in(User::getJurusans())],
            'gender' => ['nullable', Rule::in(['L', 'P'])],
            'birth_date' => 'nullable|date',
        ]);

        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $student->update($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(User $student)
    {
        // Ensure we're deleting a student
        if ($student->role !== User::ROLE_MURID) {
            return redirect()->route('admin.students.index')
                ->with('error', 'User bukan siswa');
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}
