<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserNotSuspended
{
    /**
     * Block suspended users from making authenticated requests
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->isSuspended() && !$user->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $reason = $user->status_reason ?: 'Violation of platform safety and trade policies.';
                return redirect()->route('login')->with('error', "Your account has been suspended. Reason: {$reason}");
            }
        }

        return $next($request);
    }
}
