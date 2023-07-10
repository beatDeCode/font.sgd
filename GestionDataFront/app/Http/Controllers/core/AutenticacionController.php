<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\MCoreUsuarios;

class AutenticacionController extends Controller{
    function fnIndex(){
    	return view('admin-template.login');
    }
    function fnInicioSesion(Request $request){
        $vValorUsuario=strtoupper($request->post('cd_usuario'));
        $vValorClave=sha1($request->post('tx_clave'));
    	$vQueryAutenticacion=
			    	'SELECT 
			    		cd_usuario, (select (select tx_rol from coreroles core where usro.cd_rol=core.cd_rol )
                        from COREUSUARIOSROL usro where cd_usuario=us.cd_usuario and cd_app=1) rol, nm_usuario
			    	FROM coreusuario us
			    	where cd_usuario=upper(?)
			    	and tx_clave=?';
    	$vBusquedaAutenticacion=DB::select($vQueryAutenticacion,[$vValorUsuario,$vValorClave]);
    	if(sizeof($vBusquedaAutenticacion)>0){
    		Session::put('user', ['cd_usuario'=>$vBusquedaAutenticacion[0]->cd_usuario,
    							  'cd_rol'=>$vBusquedaAutenticacion[0]->rol,
    							  'nm_usuario'=>$vBusquedaAutenticacion[0]->nm_usuario]);
    		return redirect()->route('sgd-menu');
    	}else{
            return redirect()->route('sgd-inicio');
        }

    }
    function fnMenuInicial(){
        $vMenu=0;
        $vSubmenu=0;
        $vScripts=[];
        return view('prueba',compact('vMenu','vSubmenu','vScripts'));
        
    }
    public static function  fnArmarSideBar(){
        $vSideBar='';
        try {
            $vUsuario=Session::get('user')['cd_usuario'];
            $vQueryTitulosSidebar=
                    'SELECT 
                    cd_menu, 
                    (SELECT tx_menu from coremenu where cd_menu=a1.cd_menu)tx_menu
                    from(
                        SELECT 
                            (SELECT cd_menu_padre from coremenu where cd_menu=menu.cd_menu_padre group by cd_menu_padre)cd_menu
                            --count(1)
                        from coreusuariosrol usro, coremenurol mero, coremenu menu
                        where usro.cd_usuario=?
                        and usro.cd_rol=mero.cd_rol
                        and mero.cd_menu=menu.cd_menu
                        and menu.tp_menu=3
                    )a1
                    group by cd_menu 
                    ';
            $vQueryMenusSidebar=
                    'SELECT 
                        cd_menu,tx_menu,tx_icono,tx_enlace, cd_orden
                        from coremenu menu
                    where cd_menu in (
                        SELECT
                            cd_menu_padre
                        from coreusuariosrol usro,
                        coremenurol mero, 
                        coremenu menu
                        where usro.cd_usuario=?
                        and usro.cd_rol=mero.cd_rol
                        and mero.cd_menu=menu.cd_menu
                        and menu.tp_menu=3
                        group by cd_menu_padre
                    )and cd_menu_padre=?
                    group by cd_menu,tx_menu,tx_icono,tx_enlace,cd_orden
                    order by cd_orden asc
                    ';
            $vQuerySubMenusSidebar=
                'SELECT
                    menu.cd_menu,menu.tx_menu,menu.tx_enlace
                from 
                coreusuariosrol usro, 
                coremenurol mero, 
                coremenu menu
                where
                usro.cd_rol=mero.cd_rol
                and mero.cd_menu=menu.cd_menu
                and menu.tp_menu=3
                and usro.cd_usuario=?
                and menu.cd_menu_padre=?
                order by cd_orden asc
                ';
            $vBusquedaSidebar=DB::select($vQueryTitulosSidebar,[$vUsuario]);
            $vTitulo='<li class="nav-title">$vTitulo$</li>';
            $vLiApertura='<li class="nav-group" id="li-$vIdMenu$" aria-expanded="false"><a class="nav-link nav-group-toggle" href="#">';
            $vTituloMenu='<svg class="nav-icon"><use xlink:href="/vendors/@coreui/icons/svg/free.svg#$vIcono$"></use></svg> $vNombreTitulo$</a>';
            $vUlApertura='<ul class="nav-group-items">';
            $vTituloSubMenu='<li class="nav-item"><a class="nav-link" id="sm-a-$vIdSubMenu$" href="$vURL$"><span class="nav-icon"></span> - $vNombreSubMenu$</a></li>';
            $vUlCierre='</ul>';
            $vLiCierre='</li>';
           
            for($indice=0;$indice<sizeof($vBusquedaSidebar);$indice++){
                $vReemplazoTitulo=
                    str_replace('$vTitulo$',
                        $vBusquedaSidebar[$indice]->tx_menu,
                        $vTitulo);
                $vSideBar.=$vReemplazoTitulo;
                $vBusquedaSidebar2=DB::select($vQueryMenusSidebar,[$vUsuario,$vBusquedaSidebar[$indice]->cd_menu]);
                
                //dd($vBusquedaSidebar2);
                for ($indice2=0; $indice2 < sizeof($vBusquedaSidebar2); $indice2++) { 
                    $vMenus='';
                    $vReemplazoLiApertura='';
                    $vReemplazoLiApertura=str_replace(
                        '$vIdMenu$',
                        $vBusquedaSidebar2[$indice2]->cd_menu,
                        $vLiApertura);
                    $vMenus.=$vReemplazoLiApertura;
                    $vReemplazoIconoMenu=str_replace(
                        '$vIcono$',
                        $vBusquedaSidebar2[$indice2]->tx_icono,
                        $vTituloMenu);
                    $vReemplazoTituloMenu=str_replace(
                        '$vNombreTitulo$',
                        $vBusquedaSidebar2[$indice2]->tx_menu,
                        $vReemplazoIconoMenu);

                    $vMenus.=$vReemplazoTituloMenu;
                    $vBusquedaSidebar3=DB::select($vQuerySubMenusSidebar,[$vUsuario,$vBusquedaSidebar2[$indice2]->cd_menu]);
                    $vSubmenus='';
                    $vSubmenus.=$vUlApertura;
                    for($indice3=0; $indice3 < sizeof($vBusquedaSidebar3); $indice3++){
                        $vReemplazoTituloSubMenu=str_replace(
                            '$vNombreSubMenu$',
                            $vBusquedaSidebar3[$indice3]->tx_menu,
                            $vTituloSubMenu);
                        $vReemplazoIdSubMenu=str_replace(
                                '$vIdSubMenu$',
                                $vBusquedaSidebar3[$indice3]->cd_menu,
                                $vReemplazoTituloSubMenu);
                        $vReemplazoURL=str_replace(
                                '$vURL$',
                                $vBusquedaSidebar3[$indice3]->tx_enlace,
                                $vReemplazoIdSubMenu);

                        $vSubmenus.=$vReemplazoURL;
                    }
                    $vSubmenus.=$vUlCierre;
                    $vMenus.=$vSubmenus.''.$vLiCierre;
                    $vSideBar.=$vMenus;
                }
                
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
        print_r ($vSideBar);
    }
    public function fnValidarSesion(){
		$vRetorno=array();
    	$vSesion=Session::get('user');
		if($vSesion){
			$vRetorno[0]='Si hay sesión disponible.';
		}
    	echo json_encode($vRetorno);
    }
    public function fnCierraSession(){
        session()->forget('user');
        return redirect()->route('sgd-inicio');
    }

    public function fnIndiceCambioClave(){
        return view('admin-template.cambio-clave');
    }
    public function fnCambioClave(Request $request){
        $vRetorno=0;
        try {
            $vInstanciaUsuarios=new MCoreUsuarios;
            $vRetorno=$vInstanciaUsuarios->fnCambioClave($request); 
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vRetorno;
    }
}
