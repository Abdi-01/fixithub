<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Tambahkan header Content-Security-Policy
        $response->headers->set('Content-Security-Policy', "default-src 'self'; style-src 'self' 'unsafe-inline';");

        return $response;
    }
}
