<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
