<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WaliKelasMiddleware
{
  /**
   * Handle an incoming request for wali kelas users only.
   * Wali kelas = guru role + kelas_wali assigned
   */
  public function handle(Request $request, Closure $next): Response
  {
    $user = Auth::user();

    if (!$user) {
      return redirect()->route('login');
    }

    if (!$user->isGuru() || empty($user->kelas_wali)) {
      // Regular guru -> dashboard.guru, others -> dashboard
      $redirectRoute = $user->isGuru() ? 'dashboard.guru' : 'dashboard';
      \Log::info("WaliKelasMiddleware blocked: User {$user->email} (role: {$user->role}, kelas_wali: {$user->kelas_wali}) -> {$redirectRoute}");
      return redirect()->route($redirectRoute);
    }

    return $next($request);
  }
}
