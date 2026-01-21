<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureLoggedIn
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
        // Check if user exists in session
        if (!session()->has('user')) {
            return redirect('/login')->with('message', 'Please login to access the dashboard.');
        }

        return $next($request);
    }
}
