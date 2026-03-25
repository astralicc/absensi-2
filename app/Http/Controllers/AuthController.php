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
use Laravel\Socialite\Facades\Socialite;

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

    // Add Google data if available (from Google signup flow)
    if ($request->has('google_id') && $request->has('google_token')) {
      $userData['google_id'] = $request->google_id;
      $userData['google_token'] = $request->google_token;
      
      if ($request->has('avatar')) {
        $userData['avatar'] = $request->avatar;
      }
      
      \Log::info("User registered with Google OAuth - Email: {$validated['email']}");
    }

    $user = User::create($userData);

    // Log registration
    \Log::info("New user registered - Name: {$user->name}, Email: {$user->email}, Role: {$user->role}, NISN: " . ($user->nisn ?? 'N/A'));

    // Clear Google signup session data
    if (session()->has('google_signup_data')) {
      session()->forget('google_signup_data');
    }

    // Auto login after registration
    Auth::login($user);

    $request->session()->regenerate();

    // Redirect based on role
    return $this->redirectBasedOnRole($user);
  }

  /**
   * Redirect to Google for OAuth authentication (Login)
   */
  public function redirectToGoogle()
  {
    session(['google_auth_type' => 'login']);
    return Socialite::driver('google')->redirect();
  }

  /**
   * Redirect to Google for OAuth authentication (Signup)
   */
  public function redirectToGoogleSignup()
  {
    session(['google_auth_type' => 'signup']);
    return Socialite::driver('google')->redirect();
  }

  /**
   * Handle Google OAuth callback
   */
  public function handleGoogleCallback()
  {
    try {
      $googleUser = Socialite::driver('google')->user();
      
      $authType = session('google_auth_type', 'login');
      
      // If signup flow, store data and redirect to signup form
      if ($authType === 'signup') {
        return $this->handleGoogleSignupCallback($googleUser);
      }
      
      // Find or create user based on Google email
      $user = $this->findOrCreateGoogleUser($googleUser);
      
      if (!$user) {
        return redirect()->route('login')
          ->withErrors(['email' => 'Akun Google tidak terdaftar dalam sistem. Silakan hubungi admin.']);
      }
      
      // Log the login attempt
      $this->logLoginAttempt($user, request(), true);
      
      // Authenticate user
      Auth::login($user, true);
      
      // Regenerate session for security
      request()->session()->regenerate();
      
      // Redirect based on role
      return $this->redirectBasedOnRole($user);
      
    } catch (\Exception $e) {
      Log::error('Google login error: ' . $e->getMessage());
      return redirect()->route('login')
        ->withErrors(['email' => 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.']);
    }
  }

  /**
   * Handle Google OAuth callback for signup flow
   */
  private function handleGoogleSignupCallback($googleUser)
  {
    // Check if user already exists
    $existingUser = User::where('email', $googleUser->email)->first();
    
    if ($existingUser) {
      return redirect()->route('signup')
        ->withErrors(['email' => 'Email ini sudah terdaftar. Silakan login saja.']);
    }
    
    // Extract NISN from Google user data if available
    // Google doesn't provide NISN directly, but we can try to get it from custom claims or user metadata
    $nisn = $this->extractNisnFromGoogleUser($googleUser);
    
    // Store Google data in session for pre-filling signup form
    session([
      'google_signup_data' => [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'google_id' => $googleUser->id,
        'google_token' => $googleUser->token,
        'avatar' => $googleUser->avatar,
        'nisn' => $nisn, // May be null if not available
      ]
    ]);
    
    \Log::info("Google signup data stored for email: {$googleUser->email}, NISN: " . ($nisn ?? 'N/A'));
    
    // Redirect to signup form with pre-filled data
    return redirect()->route('signup');
  }

  /**
   * Extract NISN from Google user data
   * Note: Standard Google OAuth doesn't provide NISN.
   * This method attempts to extract from custom claims or returns null.
   */
  private function extractNisnFromGoogleUser($googleUser): ?string
  {
    // Try to get NISN from user attributes if available
    // Some educational Google Workspace domains may include custom claims
    
    // Check if there's any custom data in the user object
    if (isset($googleUser->user['nisn'])) {
      return $googleUser->user['nisn'];
    }
    
    // For akun belajar.id integration, NISN might be in a specific claim
    // This would require custom configuration with the education provider
    
    return null;
  }

  /**
   * Find or create user from Google OAuth data
   */
  private function findOrCreateGoogleUser($googleUser): ?User
  {
    // First, try to find user by Google ID
    $user = User::where('google_id', $googleUser->id)->first();
    
    if ($user) {
      return $user;
    }
    
    // Try to find user by email
    $user = User::where('email', $googleUser->email)->first();
    
    if ($user) {
      // Link Google account to existing user
      $user->update([
        'google_id' => $googleUser->id,
        'google_token' => $googleUser->token,
        'avatar' => $googleUser->avatar,
      ]);
      return $user;
    }
    
    // Auto-create new user from Google data
    // Generate a unique identifier from Google ID
    $identifier = 'G' . substr($googleUser->id, -8);
    
    $user = User::create([
      'name' => $googleUser->name,
      'email' => $googleUser->email,
      'password' => Hash::make(Str::random(16)), // Random password, user will use Google login
      'role' => User::ROLE_MURID, // Default role, admin can change later
      'device_user_id' => $identifier,
      'google_id' => $googleUser->id,
      'google_token' => $googleUser->token,
      'avatar' => $googleUser->avatar,
    ]);
    
    \Log::info("New user auto-created from Google OAuth - Name: {$user->name}, Email: {$user->email}, ID: {$user->id}");
    
    return $user;
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
