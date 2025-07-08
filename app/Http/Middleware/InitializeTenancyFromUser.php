<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenancyFromUser
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->tenant_id) {
            tenancy()->initialize(auth()->user()->tenant_id);
        }

        return $next($request);
    }
}
