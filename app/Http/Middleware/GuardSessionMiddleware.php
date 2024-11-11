<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuardSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (is_null($user)) {
            // not logged in
            return $next($request);
        }

        if ($user->session_hash !== $request->session()->get('app.session_hash')) {
            auth()->guard('web')->logout();
            $request->session()->invalidate();

            throw new \Illuminate\Auth\AuthenticationException;
        }

        return $next($request);
    }
}
