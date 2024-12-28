<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaticFilesMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Redirect request ke folder public/build jika file ditemukan
        $file = public_path('build' . $request->getPathInfo());
        if (file_exists($file)) {
            return response()->file($file);
        }

        return $next($request);
    }
}
