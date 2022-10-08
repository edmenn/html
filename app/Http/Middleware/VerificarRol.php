<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarRol
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
        // obtenemos los roles pasados por parametro (a partir del 3er parametro, el 1ero es $request y el 2do $next)
        $roles = array_slice( func_get_args(), 2 );
        if(!in_array($request->user()->rol->nombre, $roles)){
            return response()->json(['message' => 'No tiene los suficientes permisos para acceder a este recurso.'], 403);
        }

        return $next($request);
    }
}
