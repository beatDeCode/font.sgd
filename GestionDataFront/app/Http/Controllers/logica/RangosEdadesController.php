<?php

namespace App\Http\Controllers\logica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MCoreReporteEdad;
use App\Models\MCoreAliadoPorProducto;

class RangosEdadesController extends Controller{
    function fnIndex($pCdAliado){
    		
    	$vRangosEdad=array();
    	$vNombreAliado='Sin Selección';
        try {
        	$vInstanciaAliadosPorProducto= new MCoreAliadoPorProducto ;
        	$vOptionsAliadosPermitidos=$vInstanciaAliadosPorProducto->fnAliadosPermitidos();
        	if($pCdAliado=='$AL'){}else{
        		$vInstanciaRangos=new MCoreReporteEdad;
    			$vRangosEdad=$vInstanciaRangos->fnListarPorAliado($pCdAliado);
    			$vNombreAliado=$vInstanciaRangos->fnBuscarNombreAliado($pCdAliado)[0]['de_dato'];
        	}
            $vMenu=506;
            $vSubmenu =510;
            $vLongitudColumnas='8 offset-md-2';
            $vTituloTarjeta ='Rango de Edades en la Data Óptima.';
            $vCdAliado=$pCdAliado;
            $vScripts=array('buslogic/core.js','negocio/logica/rango-edades.js');
            return view('logica.rango-edades', compact(
                'vMenu','vSubmenu','vTituloTarjeta','vScripts','vOptionsAliadosPermitidos','vRangosEdad','vLongitudColumnas','vNombreAliado','vCdAliado'
            ));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function fnAgregar(Request $request){
        $vRetorno=0;
        try {
            $vArregloRangosEdades=$request->all();
            $vInstanciaRangosEdad=new MCoreReporteEdad;
            $vCondicion=99;
            if(sizeof($vArregloRangosEdades)>0){
                for($indice=0;$indice< sizeof($vArregloRangosEdades);$indice++){
                    if($vArregloRangosEdades[$indice]['cd_rango_edad']){ }else{
                        $vCondicion=1;
                    }
                    $vRetorno=$vInstanciaRangosEdad->fnModificar($vArregloRangosEdades[$indice],$vCondicion);
                }
            }
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vRetorno;
    }
    function fnEliminar($pCdRangoEdad){
        $vRetorno=0;
        try {
            $vInstanciaRangosEdad=new MCoreReporteEdad;
            $vRetorno=$vInstanciaRangosEdad->fnEliminar($pCdRangoEdad);
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vRetorno;
    }
    
}
