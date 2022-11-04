<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $roles = [
            'admin' => [0],
            'secretary' => [1],
            'resident' => [2]
        ];

        $roleIds = $roles[$role] ?? [];

        if(!in_array(auth()->user()->is_role, $roleIds)){
            abort(403);
        }

        return $next($request);
    }
}
