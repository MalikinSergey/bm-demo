<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiVersion
{
    public function handle(Request $request, Closure $next, $version)
    {
        config(['app.api.version' => $version]);
        return $next($request);
    }
}