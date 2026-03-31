<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List all siswa
    public function index()
    {
        $users = Siswa::all();
        return response()->json($users);
    }

    // Show single siswa
    public function show($id)
    {
        $user = Siswa::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found!'], 404);
        }
        return response()->json($user);
    }

    // Create new siswa
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:siswa',
            'password' => 'required|string',
            'nis' => 'nullable|string|unique:siswa',
        ]);

        $user = Siswa::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'nis' => $request->nis,
        ]);

        return response()->json($user, 201);
    }

    // Update siswa
    public function update(Request $request, $id)
    {
        $user = Siswa::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:siswa,email,' . $id,
            'password' => 'sometimes|string',
            'nis' => 'nullable|string|unique:siswa,nis,' . $id,
        ]);

        if ($request->has('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        $user->update($request->only('name', 'email', 'password', 'nis'));

        return response()->json($user);
    }

    // Delete siswa
    public function destroy($id)
    {
        $user = Siswa::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
