<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $user = Auth::user();

        // 1. Administrators have superuser access to both Admin and Seller sections
        if ($user->isAdmin()) {
            return $next($request);
        }

        // 2. Check if user has one of the required roles
        if (!in_array($user->role, $roles)) {
            // For customers trying to access the seller portal, redirect to login with friendly alert
            if ($request->is('seller*')) {
                return redirect()->route('login')->with('error', 'Access Denied');
            }

            if ($request->is('admin*')) {
                return redirect()->route('login')->with('error', 'Access Denied');
            }

            abort(403, 'Unauthorized access: You do not have permission for this section.');
        }

        return $next($request);
    }
}
