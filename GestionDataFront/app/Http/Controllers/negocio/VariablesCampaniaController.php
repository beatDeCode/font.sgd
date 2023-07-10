<?php

namespace App\Http\Controllers\negocio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MCoreCampania;
use App\Models\MCoreVariablesCallCenter;
use App\Models\MCoreParametros;


class VariablesCampaniaController extends Controller{

    public function fnIndice($pNivel){
        $vOptionsNiveles=array();
        $vOptionsVariablesPadres=array();
        $vOptionsAcciones=array();
        $vOptionsDependencia=array();
        $vVariables=array();
        $vOptionsDecisionFinal=array();
        $vVariableCierreContacto=array();
        $vVariablesParaNC=array();
        $vNivel=$pNivel;
        try {
            $vInstanciaCampania=new MCoreVariablesCallCenter;
            if($pNivel!='$AL'){
                $vOptionsAcciones=$vInstanciaCampania->fnCustomQuery(array('cd_tabla'=>'1'),'vListarParametrosMust');
                $vOptionsVariablesPadres=$vInstanciaCampania->fnCustomQuery(array('nu_nivel'=>$pNivel),'vListarVariablesPadre');
                $vVariables=$vInstanciaCampania->fnCustomQuery(array('nu_nivel'=>$pNivel),'vListarVariablesPorNivel');
                $vVariablesParaNC=$vInstanciaCampania->fnCustomQuery(array('nu_nivel'=>1),'vListarVariablesPorNivelSelect');
                $vOptionsDependencia=$vInstanciaCampania->fnCustomQuery(array('cd_tabla'=>'2'),'vListarParametrosMust');
                $vVariableCierreContacto=$vInstanciaCampania->fnCustomQuery(array('cd_tabla'=>'CC_VARIABLE_NC'),'vValorParametro');

                
                $vOptionsDecisionFinal=$vOptionsDependencia;
            }
            $vOptionsDependencia=$vInstanciaCampania->fnCustomQuery(array('cd_tabla'=>'2'),'vListarParametrosMust');
            $vOptionsNiveles=$vInstanciaCampania->fnCustomQuery(array('cd_tabla'=>'PR_NIVELES'),'vListarParametros');
            $vOptionsAcciones=$vInstanciaCampania->fnCustomQuery(array('cd_tabla'=>'1'),'vListarParametrosMust');
            $vMenu=512;
            $vSubmenu =516;
            $vLongitudColumnas='12';
            $vTituloTarjeta ='Variables para Formulario de Campaña.';
            $vScripts=array('buslogic/core.js','negocio/campania/campania-variables.js');
            return view('negocio.campania.campania-variables', compact(
                'vMenu','vSubmenu','vLongitudColumnas','vTituloTarjeta','vScripts','vOptionsNiveles',
                'vOptionsVariablesPadres','vOptionsAcciones','vOptionsDependencia','vVariables','vNivel','vOptionsDecisionFinal','vVariableCierreContacto','vVariablesParaNC'
            ));    
        } catch (Exception $th) {
            $th->getMessage();
        }
        return view('');
    }
    function fnEliminar($pCdVariable){
        $vRetorno=0;
        try {
            $vInstanciaVariables=new MCoreVariablesCallCenter;
            $vRetorno=$vInstanciaVariables->fnEliminar($pCdVariable);
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vRetorno;
    }
    function fnAgregar(Request $request){
        $vRetorno=0;
        try {
            $vArregloVariables=$request->all();
            $vInstanciaRangosEdad=new MCoreVariablesCallCenter;
            $vCondicion=99;
            if(sizeof($vArregloVariables)>0){
                for($indice=0;$indice< sizeof($vArregloVariables);$indice++){
                    if($vArregloVariables[$indice]['cd_variable']){ }else{
                        $vCondicion=1;
                    }
                    $vRetorno=$vInstanciaRangosEdad->fnModificar($vArregloVariables[$indice],$vCondicion);
                }
            }
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vRetorno;
    }
    function fnAgregarVariableDeCierre($pCdParametro,$pCdVariable){
        $vRetorno=0;
        try {
            $vInstanciaCampania=new MCoreVariablesCallCenter;
            $vInstanciaParametros=new MCoreParametros;
            $vVariableExiste=$vInstanciaCampania->fnCustomQuery(array('cd_tabla'=>'CC_VARIABLE_NC'),'vValorParametro');
            $vArrayParametros=array();
            if(sizeof($vVariableExiste)>0){
                $vArrayParametros['cd_parametro']=$pCdParametro;
                $vArrayParametros['cd_valor']=$pCdVariable;
                $vRetorno=$vInstanciaParametros->fnActualizarParametro($vArrayParametros);
            }else{
                $vArrayParametros['cd_valor']=$pCdVariable;
                $vRetorno=$vInstanciaParametros->fnAgregarParametro($vArrayParametros);
                
            }
            return $vRetorno;
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function fnBuscarFormularioTecnico($pCdVariable){
        $vRetorno=array();
        try {
            $vInstanciaCampania=new MCoreVariablesCallCenter;
            $vRetorno=$vInstanciaCampania->fnCustomQuery(array('cd_variable'=>$pCdVariable),'vBuscarFormularioTecnico');
            return $vRetorno;
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function fnBuscarSumaAsegurada($pCdVariable,$pCdCampania){
        $vRetorno=array();
        try {
            $vInstanciaCampania=new MCoreVariablesCallCenter;
            $vRetorno=$vInstanciaCampania->fnCustomQuery(array('cd_variable'=>$pCdVariable,'cd_campania'=>$pCdCampania),'vSumasAseguradasPorDato');
            return $vRetorno;
        } catch (Exception $e) {
            $e->getMessage();
        }
    } 
    function fnBuscarAdicionales(){
        $vRetorno=array();
        try {
            $vInstanciaCampania=new MCoreVariablesCallCenter;
            $vRetorno=$vInstanciaCampania->fnCustomQuery(array(),'vFamiliaresAdicionales');
            return $vRetorno;
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    
    
}
