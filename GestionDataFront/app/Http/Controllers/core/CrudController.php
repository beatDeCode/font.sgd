<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrudController extends Controller{

    public function fnIndexPorModelo($pModelo){
        $vPathModelo='\App\\Models\\core\\'.$pModelo;
        //$vPathModelo= 'App\\models\\core\\'.$pModelo;
		$vInstanciaModelo=new $vPathModelo;
        $vConfiguracionPorModelo=$vInstanciaModelo->fnConfiguracion();
        $vNombreController=$pModelo;
        $vFuncionController=$vConfiguracionPorModelo['funcionController'];
        $pTituloTarjeta=$vConfiguracionPorModelo['nombreTarjeta'];
        $vScript=$vConfiguracionPorModelo['scriptsJs'];
        $vNombreModulo=$vConfiguracionPorModelo['nombreModulo'];
        $vNombreModuloAdicional=$vConfiguracionPorModelo['nombreModuloAdicional'];
        $vNombreTabla='*';
		return view('crudTemplates.VXCobListar',
            compact('vScript','pTituloTarjeta','vNombreTabla','vFuncionController','vNombreController','vNombreModulo','vNombreModuloAdicional'));
    }
    public function fnListarPorModelos($pModelo){
        $vRetorno='';
        try {
            $vInstanciaDelModelo= '\App\Models\\'.$pModelo;
		    $vRetorno=new $vInstanciaDelModelo;
        } catch (Exception $ex) {
            $ex->getMesssage();
        }
        return $vRetorno->fnListar();
    } 
    
    public function fnAgregar(Request $request){
        $vRespuesta='';
        try {
            $vPathModelo= 'App\\Models\\'.$request->get('nombreController_cd');
            $vInstanciaModelo=new $vPathModelo;
            $vRespuesta=$vInstanciaModelo->fnAgregar($request);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        echo json_encode($vRespuesta);
    }
    public function fnListarSelects($pModelo){
        $vRetorno='';
        try {
            $vInstanciaDelModelo= '\App\Models\\'.$pModelo;
		    $vRetorno=new $vInstanciaDelModelo;
        } catch (Exception $ex) {
            $ex->getMesssage();
        }
        return $vRetorno->fnValoresParaSelect();
    }
    public function fnListarPorModelosEIds($pModelo,$pId){
        $vRetorno='';
        try {
            $vInstanciaDelModelo= '\App\Models\\'.$pModelo;
		    $vRetorno=new $vInstanciaDelModelo;
        } catch (Exception $ex) {
            $ex->getMesssage();
        }
        return $vRetorno->fnListarPorId($pId);
    } 
    function fnCustomQueryParaSelects($pParametro){
        $vRetornoData=[];
        $vModelo=explode('-',$pParametro);
        try {
            $vInstanciaDelModelo='\App\Models\\'.$vModelo[0];
		    $vRetorno=new $vInstanciaDelModelo;
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetorno->fnCustomQueryParaSelects(array(),$vModelo[1]);
    }
    public function fnActualizar(Request $request){
        $vRespuesta='';
        try {
            $vPathModelo= '\App\Models\\'.$request->get('nombreController_cd');
            $vInstanciaModelo=new $vPathModelo;
            $vRespuesta=$vInstanciaModelo->fnActualizar($request);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRespuesta;
    }
    public function fnEliminar(Request $request){
        $vRespuesta=0;
        try {
            $vSeparacionStr=explode('|',$request->get('vData'));
            $vModelo=$vSeparacionStr[0];
            $vId=$vSeparacionStr[1];
            $vPathModelo= 'App\\models\\'.$vModelo;
            $vInstanciaModelo=new $vPathModelo;
            $vRespuesta=$vInstanciaModelo->fnEliminar($vId);
            $vRespuesta=1;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRespuesta;
    }
    
}
