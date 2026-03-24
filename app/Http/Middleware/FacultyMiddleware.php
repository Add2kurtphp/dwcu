<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacultyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('faculty_id')) {
            return redirect()->route('faculty.login');
        }

        return $next($request);
    }
}
