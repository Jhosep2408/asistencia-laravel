<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfessorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isProfessor()) {
            return $next($request);
        }
        
        return redirect('/')->with('error', 'No tienes permiso para acceder a esta sección');
    }
}