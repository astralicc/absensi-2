<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
  /**
   * Handle an incoming request.
   * Now works with guard-based authentication instead of role column.
   */
  public function handle(Request $request, Closure $next, string $role): Response
  {
    $guardMap = [
      'murid' => 'web',
      'guru' => 'guru',
      'orang_tua' => 'ortu',
      'admin' => 'admin',
    ];

    $guard = $guardMap[$role] ?? 'web';

    if (!Auth::guard($guard)->check()) {
      \Log::warning(
        "Unauthorized access attempt - Required Role: {$role}, IP: {$request->ip()}"
      );
      abort(403);
    }

    return $next($request);
  }
}
