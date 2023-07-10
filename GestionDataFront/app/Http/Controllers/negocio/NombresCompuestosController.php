<?php

namespace App\Http\Controllers\negocio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MCoreRemesa;
use App\Models\MCoreGestionRemesa;
use Session;

class NombresCompuestosController extends Controller{
    function fnIndex($pCdRemesa){
    	$vCdRemesa='Sin Selección';
        $vNombresCompuestos=[];
        try {
        	$vInstanciaRemesa= new MCoreRemesa ;
        	$vOptionsRemesas=$vInstanciaRemesa->fnCustomQuery(array(),'vListaDeRemesasConNombresCompuestos');
        	if($pCdRemesa=='$AL'){}else{
                $vParametros=array(
                    'cd_remesa'=>$pCdRemesa,
                    'cd_usuario'=>Session::get('user')['cd_usuario'],
            );
                 $vRetornoData=$vInstanciaRemesa->fnCustomUpdate(
                $vParametros,'vActualizarListaDeRemesasConNombresCompuestos');
    			$vNombresCompuestos=$vInstanciaRemesa->fnCustomQuery($vParametros,'vListasDeNombresCompuestos');
                $vCdRemesa=$pCdRemesa;
        	}
            $vMenu=501;
            $vSubmenu =511;
            $vLongitudColumnas='10 offset-md-1';
            $vTituloTarjeta ='Actualización de los Nombres Compuestos de una Remesa.';
            $vScripts=array('buslogic/core.js','negocio/remesa/nombres-compuestos.js');
            return view('negocio.remesa.remesa-nombres-compuestos', compact(
                'vMenu','vSubmenu','vTituloTarjeta','vScripts','vOptionsRemesas','vLongitudColumnas','vCdRemesa','vNombresCompuestos'
            ));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function fnAgregar(Request $request){
        $vRetorno=0;
        try {
            $vNombresCompuestos=$request->all();
            $vInstanciaGestionRemesa=new MCoreGestionRemesa;
            $vCondicion=99;
            if(sizeof($vNombresCompuestos)>0){
                for($indice=0;$indice< sizeof($vNombresCompuestos);$indice++){
                    $vRetorno=$vInstanciaGestionRemesa->fnModificar($vNombresCompuestos[$indice]);
                }
            }
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vRetorno;
    }
}
