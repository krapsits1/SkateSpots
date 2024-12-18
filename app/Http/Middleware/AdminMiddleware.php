<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
    
        if (Auth::user()->role !== 'admin') {
            return redirect('/home');
        }

        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        return redirect('/home')->with('error', 'You are not authorized to access this page.');
    }
}
