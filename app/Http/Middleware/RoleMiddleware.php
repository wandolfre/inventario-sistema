<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  (el rol requerido)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            // No está autenticado, redirige al login
            return redirect('login');
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            // No tiene el rol requerido
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
