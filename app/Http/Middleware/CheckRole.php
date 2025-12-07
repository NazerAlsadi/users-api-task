<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Unauthorized'], 401)
                : redirect()->route('login')->withErrors('Please login first');
        }

        // تحقق من وجود أي من الأدوار
        if (!$user->roles()->whereIn('name', $roles)->exists()) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Forbidden'], 403)
                : redirect()->route('dashboard')->withErrors('Permission Denied');
        }

            return $next($request);
        }
}
