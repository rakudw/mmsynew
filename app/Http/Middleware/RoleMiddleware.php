<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role, $permission = null)
    {
        if(!auth()->user()->hasRole($role)) {
            abort(404);
        }

        if(auth()->user()->isApplicant()){
            return redirect('applications');
        }

        if($permission !== null && !auth()->user()->can($permission)) {
            abort(404);
        }
        return $next($request);
    }
}
