<?php

namespace Modules\Kody2\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Kody2Auth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('userid')) {
            return redirect()->route('kody2.login');
        }

        return $next($request);
    }
}
