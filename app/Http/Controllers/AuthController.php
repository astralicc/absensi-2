<?php

namespace App\Http\Controllers;

use App\Models\User;
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
   * Role mapping for validation
   */
  private const ROLE_MAPPING = [
    'Murid' => User::ROLE_MURID,
    'Guru' => User::ROLE_GURU,
    'Orang Tua' => User::ROLE_ORANGTUA,
  ];

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
    // Validate request
    $validated = $request->validate([
      'role' => ['required', 'string', 'in:Murid,Guru,Orang Tua'],
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'unique:users,email'],
      'identifier' => ['required', 'string', 'min:3', 'max:50', 'unique:users,device_user_id'],
      'nisn' => ['nullable', 'string', 'max:20', 'required_if:role,Murid'],
      'child_name' => ['nullable', 'string', 'max:100', 'required_if:role,Orang Tua'],
      'class' => ['exclude_unless:role,Murid', 'required', Rule::in(User::getClasses())],
      'jurusan' => ['exclude_unless:role,Murid', 'required', Rule::in(User::getJurusans())],
      'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);

    $role = self::ROLE_MAPPING[$validated['role']];

    // Create new user
    $userData = [
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
      'role' => $role,
      'device_user_id' => $validated['identifier'],
    ];

    // Add NISN if provided (for Murid)
    if (!empty($validated['nisn'])) {
      $userData['nisn'] = $validated['nisn'];
    }

    if ($role === User::ROLE_MURID) {
      $userData['class'] = $validated['class'];
      $userData['jurusan'] = $validated['jurusan'];
    }

    $user = User::create($userData);

    // Log registration
    \Log::info("New user registered - Name: {$user->name}, Email: {$user->email}, Role: {$user->role}, NISN: " . ($user->nisn ?? 'N/A'));

    // Auto login after registration
    Auth::login($user);

    $request->session()->regenerate();

    // Redirect based on role
    return $this->redirectBasedOnRole($user);
  }

  /**
   * Handle admin login request
   */
  public function adminLogin(Request $request)
  {
    // Validate request
    $validated = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'string', 'min:6'],
      'remember' => ['nullable', 'boolean'],
    ]);

    $email = $validated['email'];
    $password = $validated['password'];
    $remember = $validated['remember'] ?? false;

    // Rate limiting key based on email and IP
    $throttleKey = 'admin|' . Str::lower($email) . '|' . $request->ip();

    // Check rate limiting (5 attempts per minute)
    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
      $seconds = RateLimiter::availableIn($throttleKey);
      throw ValidationException::withMessages([
        'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
      ]);
    }

    // Find admin user by email
    $user = User::where('email', $email)
      ->where('role', User::ROLE_ADMIN)
      ->first();

    if (!$user) {
      RateLimiter::hit($throttleKey);
      throw ValidationException::withMessages([
        'email' => 'Email admin tidak ditemukan.',
      ]);
    }

    // Verify password
    if (!Hash::check($password, $user->password)) {
      RateLimiter::hit($throttleKey);
      throw ValidationException::withMessages([
        'password' => 'Password yang dimasukkan salah.',
      ]);
    }

    // Clear rate limiter on successful login
    RateLimiter::clear($throttleKey);

    // Log the login attempt (successful)
    $this->logLoginAttempt($user, $request, true);

    // Authenticate user
    Auth::login($user, $remember);

    // Regenerate session for security
    $request->session()->regenerate();

    // Redirect to admin dashboard
    return redirect()->intended(route('admin.dashboard'));
  }

  /**
   * Handle login request with role-based authentication
   */
  public function login(Request $request)
  {
    // Validate request
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

    // Map role to database role
    $dbRole = self::ROLE_MAPPING[$role];

    // Rate limiting key based on role, identifier and IP
    $throttleKey = Str::lower($dbRole) . '|' . Str::lower($identifier) . '|' . $request->ip();

    // Check rate limiting (5 attempts per minute)
    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
      $seconds = RateLimiter::availableIn($throttleKey);
      throw ValidationException::withMessages([
        'identifier' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
      ]);
    }

    // Find user based on role and identifier
    $user = $this->findUserByRoleAndIdentifier($dbRole, $identifier);

    if (!$user) {
      RateLimiter::hit($throttleKey);
      throw ValidationException::withMessages([
        'identifier' => 'Identitas tidak ditemukan atau tidak sesuai dengan peran yang dipilih.',
      ]);
    }

    // Verify password
    if (!Hash::check($password, $user->password)) {
      RateLimiter::hit($throttleKey);
      throw ValidationException::withMessages([
        'password' => 'Password yang dimasukkan salah.',
      ]);
    }

    // Check if user role matches
    if ($user->role !== $dbRole) {
      RateLimiter::hit($throttleKey);
      throw ValidationException::withMessages([
        'role' => 'Peran pengguna tidak sesuai dengan akun yang ditemukan.',
      ]);
    }

    // Clear rate limiter on successful login
    RateLimiter::clear($throttleKey);

    // Log the login attempt (successful)
    $this->logLoginAttempt($user, $request, true);

    // Authenticate user
    Auth::login($user, $remember);

    // Regenerate session for security
    $request->session()->regenerate();

    // Redirect based on role
    return $this->redirectBasedOnRole($user);
  }

  /**
   * Find user based on role and identifier (NISN for murid, NIP for guru, ID for orang tua)
   */
  private function findUserByRoleAndIdentifier(string $role, string $identifier): ?User
  {
    $query = User::where('role', $role);

    // Build search conditions based on role
    $query->where(function ($q) use ($identifier, $role) {
      // Always allow login with email
      $q->where('email', $identifier);

      // For murid: search by NISN (nisn field) or NIS (device_user_id)
      if ($role === User::ROLE_MURID) {
        $q->orWhere('nisn', $identifier)
          ->orWhere('device_user_id', $identifier);
      }
      // For guru: search by NIP (device_user_id)
      elseif ($role === User::ROLE_GURU) {
        $q->orWhere('device_user_id', $identifier);
      }
      // For orang tua: search by ID Orang Tua (device_user_id)
      elseif ($role === User::ROLE_ORANGTUA) {
        $q->orWhere('device_user_id', $identifier);
      }
    });

    return $query->first();
  }

  /**
   * Redirect user based on their role
   */
  private function redirectBasedOnRole(User $user)
  {
    return match ($user->role) {
      User::ROLE_MURID => redirect()->intended(route('dashboard.murid')),
      User::ROLE_GURU => redirect()->intended(route('dashboard.guru')),
      User::ROLE_ORANGTUA => redirect()->intended(route('dashboard.orangtua')),
      User::ROLE_ADMIN => redirect()->intended(route('admin.dashboard')),
      default => redirect()->intended(route('dashboard')),
    };
  }

  /**
   * Log login attempt for security monitoring
   */
  private function logLoginAttempt(User $user, Request $request, bool $successful): void
  {
    // You can extend this to log to database or file
    // For now, we'll use Laravel's logging
    $status = $successful ? 'SUCCESS' : 'FAILED';
    \Log::info("Login attempt [{$status}] - User: {$user->email}, Role: {$user->role}, IP: {$request->ip()}, User-Agent: {$request->userAgent()}");
  }

  /**
   * Handle logout request
   */
  public function logout(Request $request)
  {
    // Log logout
    if (Auth::check()) {
      $user = Auth::user();
      \Log::info("Logout - User: {$user->email}, Role: {$user->role}, IP: {$request->ip()}");
    }

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return view('logout');
  }
}
