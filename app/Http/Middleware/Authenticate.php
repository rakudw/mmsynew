<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

     protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard($guards)->check()) {
            return $this->auth->shouldUse($guards);
        }

        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );
    }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('admin/*')) {
                return route('login');
            }

            return 'https://sso.hp.gov.in/login-iframe?service_id=10000074';
        }
    }
}
