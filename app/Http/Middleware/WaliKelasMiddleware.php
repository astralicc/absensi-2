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
   * Wali kelas = guru guard + kelas_wali assigned
   */
  public function handle(Request $request, Closure $next): Response
  {
    $user = Auth::guard('guru')->user();

    if (!$user) {
      return redirect()->route('login');
    }

    if (empty($user->kelas_wali)) {
      \Log::info("WaliKelasMiddleware blocked: User {$user->email} (kelas_wali: {$user->kelas_wali}) -> dashboard.guru");
      return redirect()->route('dashboard.guru');
    }

    return $next($request);
  }
}
