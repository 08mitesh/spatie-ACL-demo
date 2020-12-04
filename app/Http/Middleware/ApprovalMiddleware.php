<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApprovalMiddleware
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
        if (auth()->check()) {
            if (!auth()->user()->is_approved) {
                auth()->logout();

                return redirect()->route('login')->with('message','You need admin approval');
            }
        }

        return $next($request);
    }
}
