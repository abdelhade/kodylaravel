<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (!session('login')) {
            // Log unauthorized access attempt
            Log::warning('Unauthorized access attempt', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
            ]);
            
            // Store intended URL for redirect after login
            if ($request->isMethod('get')) {
                session(['url.intended' => $request->fullUrl()]);
            }
            
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // Check if user session is still valid
        if (!session('userid') || !session('usrole')) {
            Log::warning('Invalid session data', [
                'user_id' => session('userid'),
                'user_role' => session('usrole'),
                'ip' => $request->ip(),
            ]);
            
            session()->flush();
            return redirect()->route('login')->with('error', 'انتهت صلاحية الجلسة. يرجى تسجيل الدخول مرة أخرى');
        }

        return $next($request);
    }
}
