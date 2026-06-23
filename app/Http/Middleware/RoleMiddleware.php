<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'Please login to access this section.');
        }

        // Allow Super Admin to access everything as fallback
        if ($request->user()->isSuperAdmin()) {
            return $next($request);
        }

        if (!in_array($request->user()->role, $roles)) {
            // Find appropriate fallback route
            $fallback = 'login';
            if ($request->user()->isOrganizer()) {
                $fallback = 'organizer.dashboard';
            } elseif ($request->user()->isCandidate()) {
                $fallback = 'candidate.dashboard';
            } elseif ($request->user()->isProctor()) {
                $fallback = 'proctor.dashboard';
            }
            
            return redirect()->route($fallback)->with('error', 'Access denied. You do not have permissions for that area.');
        }

        return $next($request);
    }
}
