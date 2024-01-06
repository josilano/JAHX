<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (is_null($request->user()->permissions()->where('cod_funcao', $permission)->first()))
            return back()->with('msg', 'Você não tem permissão para executar esta ação!');
        //return redirect('erro-de-permissao')->with('msg', 'Você não tem permissão para executar esta ação!');

        return $next($request);
    }
}
