<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'nisn' => $user->nisn,
                'phone' => $user->phone,
                'address' => $user->address,
                'class' => $user->class,
                'jurusan' => $user->jurusan,
                'gender' => $user->gender,
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
        $user = Auth::user();

        $validated = $request->validate([
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
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

        // Verify current password
        // CEK PASSWORD DI SINI
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini tidak sesuai.'
            ], 422);
        }


        // Update user data
        $user->update([
            'nisn' => $validated['nisn'] ?? $user->nisn,
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'class' => $validated['class'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
        ]);
        return response()->json([
            'success' => true, // WAJIB ADA INI
            'message' => 'Profil berhasil diperbarui!',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'nisn' => $user->nisn,
                'phone' => $user->phone,
                'address' => $user->address,
                'class' => $user->class,
                'gender' => $user->gender,
                'birth_date' => $user->birth_date
                    ? $user->birth_date->format('Y-m-d')
                    : null,
            ]
        ]);
    }
}
