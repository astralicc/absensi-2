<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, string $role): Response
  {
    $user = Auth::user();

    // Check if user has the required role
    if (!$user || !$user->hasRole($role)) {
      // Log unauthorized access attempt (null-safe for stability)
      \Log::warning(
        "Unauthorized access attempt - User: " . ($user?->email ?? 'guest') .
          ", Required Role: {$role}, User Role: " . ($user?->role ?? 'guest') .
          ", IP: {$request->ip()}"
      );

      abort(403);
    }

    return $next($request);
  }

  /**
   * Redirect user to their appropriate dashboard
   */
  private function redirectToAppropriateDashboard(User $user)
  {
    return match ($user->role) {
      User::ROLE_MURID => redirect()->route('dashboard.murid'),
      User::ROLE_GURU => redirect()->route('dashboard.guru'),
      User::ROLE_ORANGTUA => redirect()->route('dashboard.orangtua'),
      User::ROLE_ADMIN => redirect()->route('admin.dashboard'),
      default => redirect()->route('dashboard'),
    };
  }
}
