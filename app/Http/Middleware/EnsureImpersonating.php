<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureImpersonating
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('impersonator_id')) {
            abort(404);
        }
        return $next($request);
    }
}
