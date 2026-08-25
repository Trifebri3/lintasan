<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.stories.index')->with('error', 'Akses dibatasi. Anda login sebagai Contributor dan hanya dapat mengelola Cerita Dampak.');
        }

        return $next($request);
    }
}
