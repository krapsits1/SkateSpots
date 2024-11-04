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
            Log::info('User not authenticated.');
            return redirect('/login');
        }
    
        if (Auth::user()->role !== 'admin') {
            Log::info('User is not an admin.');
            return redirect('/home');
        }

        if (Auth::check() && Auth::user()->role == 'admin') {
            Log::info("Admin middleware strada");
            return $next($request);
        }

        return redirect('/home')->with('error', 'You are not authorized to access this page.');
    }
}
