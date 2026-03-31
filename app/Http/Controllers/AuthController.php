<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Admin;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
  /**
   * Show login form
   */
  public function showLoginForm()
  {
    return view('login');
  }

  /**
   * Show admin login form (hidden from public)
   */
  public function showAdminLoginForm()
  {
    return view('admin.login');
  }

  /**
   * Show signup form
   */
  public function showSignupForm()
  {
    return view('signup');
  }

  /**
   * Handle registration request
   */
  public function register(Request $request)
  {
    $validated = $request->validate([
      'role' => ['required', 'string', 'in:Murid,Guru,Orang Tua'],
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email'],
      'identifier' => ['required', 'string', 'min:3', 'max:50'],
      'nisn' => ['nullable', 'string', 'max:20', 'required_if:role,Murid'],
      'child_name' => ['nullable', 'string', 'max:100', 'required_if:role,Orang Tua'],
      'class' => ['exclude_unless:role,Murid', 'required', Rule::in(Siswa::getClasses())],
      'jurusan' => ['exclude_unless:role,Murid', 'required', Rule::in(Siswa::getJurusans())],
      'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);

    $role = $validated['role'];

    if ($role === 'Murid') {
      $user = Siswa::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'],
        'nis' => $validated['identifier'],
        'nisn' => $validated['nisn'] ?? null,
        'class' => $validated['class'],
        'jurusan' => $validated['jurusan'],
      ]);
      Auth::guard('web')->login($user);
      $redirect = redirect()->intended(route('dashboard.murid'));
    } elseif ($role === 'Guru') {
      $user = Guru::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'],
        'nip' => $validated['identifier'],
      ]);
      Auth::guard('guru')->login($user);
      $redirect = redirect()->intended(route('dashboard.guru'));
    } else {
      // Orang Tua
      $user = OrangTua::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'],
        'id_ortu' => $validated['identifier'],
      ]);
      Auth::guard('ortu')->login($user);
      $redirect = redirect()->intended(route('dashboard.orangtua'));
    }

    Log::info("New user registered - Name: {$user->name}, Email: {$user->email}, Role: {$role}");
    $request->session()->regenerate();

    return $redirect;
  }

  /**
   * Handle admin login request
   */
  public function adminLogin(Request $request)
  {
    $validated = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'string', 'min:6'],
      'remember' => ['nullable', 'boolean'],
    ]);

    $email = $validated['email'];
    $password = $validated['password'];
    $remember = $validated['remember'] ?? false;

    $throttleKey = 'admin|' . Str::lower($email) . '|' . $request->ip();

    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
      $seconds = RateLimiter::availableIn($throttleKey);
      throw ValidationException::withMessages([
        'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
      ]);
    }

    $admin = Admin::where('email', $email)->first();

    if (!$admin) {
      RateLimiter::hit($throttleKey);
      throw ValidationException::withMessages([
        'email' => 'Email admin tidak ditemukan.',
      ]);
    }

    if (!Hash::check($password, $admin->password)) {
      RateLimiter::hit($throttleKey);
      throw ValidationException::withMessages([
        'password' => 'Password yang dimasukkan salah.',
      ]);
    }

    RateLimiter::clear($throttleKey);
    Log::info("Login attempt [SUCCESS] - User: {$admin->email}, Role: admin, IP: {$request->ip()}");

    Auth::guard('admin')->login($admin, $remember);
    $request->session()->regenerate();

    return redirect()->intended(route('admin.dashboard'));
  }

  /**
   * Handle login request with role-based authentication
   */
  public function login(Request $request)
  {
    $validated = $request->validate([
      'role' => ['required', 'string', 'in:Murid,Guru,Orang Tua'],
      'identifier' => ['required', 'string', 'min:3', 'max:50'],
      'child_name' => ['nullable', 'string', 'max:100', 'required_if:role,Orang Tua'],
      'password' => ['required', 'string', 'min:6'],
      'remember' => ['nullable', 'boolean'],
    ]);

    $role = $validated['role'];
    $identifier = $validated['identifier'];
    $password = $validated['password'];
    $remember = $validated['remember'] ?? false;

    $throttleKey = Str::lower($role) . '|' . Str::lower($identifier) . '|' . $request->ip();

    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
      $seconds = RateLimiter::availableIn($throttleKey);
      throw ValidationException::withMessages([
        'identifier' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
      ]);
    }

    // Find user by role and identifier
    $user = null;
    $guard = 'web';
    $redirectRoute = 'dashboard';

    if ($role === 'Murid') {
      $user = Siswa::where('email', $identifier)
        ->orWhere('nisn', $identifier)
        ->orWhere('nis', $identifier)
        ->first();
      $guard = 'web';
      $redirectRoute = 'dashboard.murid';
    } elseif ($role === 'Guru') {
      $user = Guru::where('email', $identifier)
        ->orWhere('nip', $identifier)
        ->first();
      $guard = 'guru';
      $redirectRoute = 'dashboard.guru';
    } else {
      // Orang Tua
      $user = OrangTua::where('email', $identifier)
        ->orWhere('id_ortu', $identifier)
        ->first();
      $guard = 'ortu';
      $redirectRoute = 'dashboard.orangtua';
    }

    if (!$user) {
      RateLimiter::hit($throttleKey);
      throw ValidationException::withMessages([
        'identifier' => 'Identitas tidak ditemukan atau tidak sesuai dengan peran yang dipilih.',
      ]);
    }

    if (!Hash::check($password, $user->password)) {
      RateLimiter::hit($throttleKey);
      throw ValidationException::withMessages([
        'password' => 'Password yang dimasukkan salah.',
      ]);
    }

    RateLimiter::clear($throttleKey);
    Log::info("Login attempt [SUCCESS] - User: {$user->email}, Role: {$role}, IP: {$request->ip()}");

    Auth::guard($guard)->login($user, $remember);
    $request->session()->regenerate();

    return redirect()->intended(route($redirectRoute));
  }

  /**
   * Handle logout request
   */
  public function logout(Request $request)
  {
    foreach (['web', 'guru', 'admin', 'ortu'] as $guard) {
      if (Auth::guard($guard)->check()) {
        $user = Auth::guard($guard)->user();
        Log::info("Logout - User: {$user->email}, Guard: {$guard}, IP: {$request->ip()}");
        Auth::guard($guard)->logout();
        break;
      }
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return view('logout');
  }
}
