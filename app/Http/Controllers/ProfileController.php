<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show edit profile form (for modal)
     */
    public function showEditProfile()
    {
        $user = $this->getAuthUser();

        return response()->json([
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'nisn' => $user->nisn ?? null,
                'phone' => $user->phone ?? null,
                'address' => $user->address ?? null,
                'class' => $user->class ?? null,
                'jurusan' => $user->jurusan ?? null,
                'gender' => $user->gender ?? null,
                'birth_date' => $user->birth_date
                    ? $user->birth_date->format('Y-m-d')
                    : null,
            ]
        ]);
    }

    /**
     * Update profile with password confirmation
     */
    public function updateProfile(Request $request)
    {
        $user = $this->getAuthUser();
        $table = $user->getTable();

        $validated = $request->validate([
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique($table)->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'class' => ['nullable', 'string', 'in:X,XI,XII'],
            'jurusan' => ['nullable', 'string', 'in:RPL,BR,MP,AK'],
            'gender' => ['nullable', 'in:L,P'],
            'birth_date' => ['nullable', 'date'],
            'current_password' => ['required', 'string'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi untuk menyimpan perubahan.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini tidak sesuai.'
            ], 422);
        }

        $updateData = array_filter([
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
        ], fn($v) => $v !== null);

        // Only siswa has nisn, class, jurusan
        if (Auth::guard('web')->check()) {
            $updateData['nisn'] = $validated['nisn'] ?? $user->nisn;
            $updateData['class'] = $validated['class'] ?? $user->class;
        }

        $user->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'nisn' => $user->nisn ?? null,
                'phone' => $user->phone ?? null,
                'address' => $user->address ?? null,
                'class' => $user->class ?? null,
                'gender' => $user->gender ?? null,
                'birth_date' => $user->birth_date
                    ? $user->birth_date->format('Y-m-d')
                    : null,
            ]
        ]);
    }

    /**
     * Get authenticated user from any guard
     */
    private function getAuthUser()
    {
        foreach (['web', 'guru', 'admin', 'ortu'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
        abort(401);
    }
}
