<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminParentController extends Controller
{
    public function create()
    {
        return view('admin.parents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = User::ROLE_ORANGTUA;

        User::create($validated);

        return redirect()
            ->route('admin.users.quick')
            ->with('success', 'Akun orang tua berhasil dibuat.');
    }
}
