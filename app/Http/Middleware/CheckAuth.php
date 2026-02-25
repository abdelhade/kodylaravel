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
        // Start PHP session if not already started (for backward compatibility with native code)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check both Laravel session and native PHP session for backward compatibility
        $isLoggedIn = session('login') || (isset($_SESSION['login']) && $_SESSION['login']);
        
        if (!$isLoggedIn) {
            // Store intended URL for redirect after login
            if ($request->isMethod('get')) {
                session(['url.intended' => $request->fullUrl()]);
            }
            
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // Sync native PHP session to Laravel session if needed
        if (!session('login') && isset($_SESSION['login'])) {
            session([
                'login' => $_SESSION['login'],
                'userid' => $_SESSION['userid'] ?? null,
                'usrole' => $_SESSION['usrole'] ?? null,
            ]);
        }

        // Check if user session is still valid
        $userId = session('userid') ?? $_SESSION['userid'] ?? null;
        $userRole = session('usrole') ?? $_SESSION['usrole'] ?? null;
        
        if (!$userId || !$userRole) {
            Log::warning('Invalid session data', [
                'user_id' => $userId,
                'user_role' => $userRole,
                'ip' => $request->ip(),
            ]);
            
            session()->flush();
            if (isset($_SESSION)) {
                $_SESSION = [];
            }
            return redirect()->route('login')->with('error', 'انتهت صلاحية الجلسة. يرجى تسجيل الدخول مرة أخرى');
        }

        return $next($request);
    }
}
