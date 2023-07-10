<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use DB;

class AutorizacionPorUsuarios{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $vValorDeUsuario=Session::get('usuario')['cd_usuario'];
        if($vValorDeUsuario){
            $vUri=$request->path();
            if($vUri=='sgd-inicio'){
                
            }else{
                $vBusquedaTitulo='
                   SELECT count(1) existe
                    from COREUSUARIOSROL rous,
                    coremenurol mero,
                    coremenu menu
                    
                    where rous.cd_rol=mero.cd_rol
                    and menu.cd_menu =mero.cd_menu
                    and rous.cd_usuario='ADMIN'
                    and menu.cd_app=3;
                    
                    --and menu.tx_enlace=?';
                $varMenu=DB::select($vBusquedaTitulo,[$vValorDeUsuario,$uri]);
                if($varMenu[0]->existe==1){

                }else{
                    return redirect()->route('xcob-menuinicio');
                }
            }
        }else{
            return redirect()->route('xcob-inicio');
        }
        return $next($request);
    }
}
