<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Repositories\Acesso\Acesso;
use App\Http\Repositories\Resposta\Resposta;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    
        $dadosRegistro = Acesso::permissao( $request );
        
        if( (int) $dadosRegistro['registros'] == 0 ){
            return Resposta::erroPermissao($dadosRegistro['msg']);
        }

        return $next($request);
    }
}