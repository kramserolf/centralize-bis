<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isSecretary
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
        if(auth()->user()->is_role == 1){
            return $next($request);
        }
        return back()->with(session()->flash('unrestricted', 'Ooops! You do not have access on this page.'));
    }
}
