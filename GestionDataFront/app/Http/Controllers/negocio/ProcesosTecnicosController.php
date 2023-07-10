<?php

namespace App\Http\Controllers\negocio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MCoreProcesoTecnico;
use App\Models\MCoreOrdenes;
use App\Models\MCoreCampania;
use App\Models\MCoreGestionRemesa;
use Validator;
use Constantes;
use Session;
use File;
use Response;

class ProcesosTecnicosController extends Controller{
    function fnActualizarProcesoTecnico($pCdProcesoTecnico,$pCondicion){
        $vRetorno=0;
        try {
            $vCdUsuario=Session::get('user')['cd_usuario'];
            $vInstanciaProcesoTecnico=new MCoreProcesoTecnico;
            $vInstanciaOrdenes=new MCoreOrdenes;
            $vParametros=array();
            $vParametrosGestion=array();
            $vParametrosOrdenes=array();
            $vReemplazo='';
            $vReemplazoGestion='';
            $vConstante='vActualizarProcesoTecnico';
            $vConstanteGestion='vActualizarGestionRemesaDeProcesoTecnico';
            if($pCondicion==1){
                $vParametros=array(
                    'cd_proceso_tecnico'=>$pCdProcesoTecnico,
                    'in_valor'=>1
                );
                $vReemplazo='in_solicitud_seguros';
                $vParametrosGestion=array(
                    'cd_proceso_tecnico'=>$pCdProcesoTecnico,
                    'in_valor'=>1,
                );
                $vReemplazoGestion='in_envio_solicitud_seguros';

                $vDetalleDeLaRemesa=
                $vInstanciaProcesoTecnico->fnCustomQuery(
                        array('cd_proceso_tecnico'=>$pCdProcesoTecnico),'vListaAliadoYProductoDelProcesotecnico'
                );
                $vParametrosOrdenes=array(
                    'parametro1'=>$pCdProcesoTecnico,
                    'parametro2'=>$vDetalleDeLaRemesa[0]['cd_producto'],
                    'parametro3'=>$vDetalleDeLaRemesa[0]['cd_aliado'],
                    'cd_programa'=>'2',
                    'tx_funcion_programa'=>'Solicitud de Seguros',
                    'cd_cola'=>'2',
                    'cd_usuario'=>$vCdUsuario,
                    
                );
            }
            if($pCondicion==2){
                $vParametros=array(
                    'cd_proceso_tecnico'=>$pCdProcesoTecnico,
                    'in_valor'=>99
                );
                $vReemplazo='in_emision_masiva';
                $vParametrosGestion=array(
                    'cd_proceso_tecnico'=>$pCdProcesoTecnico,
                    'in_valor'=>1,
                );
                $vReemplazoGestion='in_valida_emision';
                $vParametrosOrdenes=array(
                    'parametro1'=>$pCdProcesoTecnico,
                    'cd_programa'=>'3',
                    'tx_funcion_programa'=>'Emision Masiva',
                    'cd_cola'=>'1',
                    'cd_usuario'=>$vCdUsuario
                );
            }
            if($pCondicion==3){
                $vParametros=array(
                    'cd_proceso_tecnico'=>$pCdProcesoTecnico,
                    'in_valor'=>1
                );
                $vReemplazo='in_envio_cuadro_poliza';
                $vParametrosGestion=array(
                    'cd_proceso_tecnico'=>$pCdProcesoTecnico,
                    'in_valor'=>1,
                );
                $vReemplazoGestion='in_envio_cuadro_poliza';
                $vParametrosOrdenes=array(
                    'parametro1'=>$pCdProcesoTecnico,
                    'cd_programa'=>'4',
                    'tx_funcion_programa'=>'Envío Cuadro Póliza',
                    'cd_cola'=>'2',
                    'cd_usuario'=>$vCdUsuario
                );
            }
            if($pCondicion==4){
                $vInstanciaCampania=new MCoreCampania;
                $vParametros=array(
                    'cd_proceso_tecnico'=>$pCdProcesoTecnico,
                    'in_valor'=>1
                );
                $vReemplazo='in_solicitud_campania';
                $vParametrosGestion=array(
                    'cd_proceso_tecnico'=>$pCdProcesoTecnico,
                    'in_valor'=>1,
                );
                $vReemplazoGestion='in_solicitud_campania';

                $vParametrosCampania=array(
                    'cd_proceso_tecnico'=>$pCdProcesoTecnico
                );
                $vRetornoInsercionCampania=$vInstanciaCampania->fnAgregar($vParametrosCampania);
                $vParametrosCampania['cd_campania']=$vRetornoInsercionCampania['cd_campania'];
                $vInstanciaCampania->fnCustomUpdate($vParametrosCampania,'vActualizarRegistrosDeLaCampania');
            }
            if(sizeof($vParametrosOrdenes)>0){
                $vInstanciaOrdenes->fnAgregar($vParametrosOrdenes);
            }
            $vInstanciaProcesoTecnico->fnCustomUpdate($vParametros,$vConstante,$vReemplazo);
            $vInstanciaProcesoTecnico->fnCustomUpdate($vParametrosGestion,$vConstanteGestion,$vReemplazoGestion);
            $vRetorno=1;


        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vRetorno;
    }

    function fnFomularioEmision($pNuDocumento){
    	$vClientes=array();
        $vErroresPorClientes=array();
        try {
        	$vInstanciaProcesos= new MCoreProcesoTecnico ;
        	$vOptionsTpDocumento=$vInstanciaProcesos->fnCustomQuery(array(),'vTiposDocumentos');
            $vOptionsTpSexo=$vInstanciaProcesos->fnCustomQuery(array(),'vTiposSexos');
            $vOptionsTpEstadoCivil=$vInstanciaProcesos->fnCustomQuery(array(),'vTiposEstadosCiviles');

        	if($pNuDocumento=='$AL'){}else{
        		$vClientes=$vInstanciaProcesos->fnCustomQuery(array('nu_documento'=>$pNuDocumento),'vListaDetalleConErrorEnEmisionPorDocumento');
                $vErroresPorClientes=$vInstanciaProcesos->fnCustomQuery(array('nu_documento'=>$pNuDocumento),'vListaErroresEmisionPorGestionRemesa');
        	}
            $vMenu=501;
            $vSubmenu =515;
            $vLongitudColumnas='12';
            $vTituloTarjeta ='Formulario para Modificación del Error en la Emision.';
            $vScripts=array('buslogic/core.js','negocio/remesa/formulario-procesos.js');
            return view('negocio.remesa.formulario-emision', compact(
                'vMenu','vSubmenu','vTituloTarjeta','vScripts','vOptionsTpSexo','vOptionsTpDocumento',
                    'vOptionsTpEstadoCivil','vLongitudColumnas','vClientes','vErroresPorClientes'
            ));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function fnActualizarFormularioEmision(Request $request){
        $vRespuesta='';
        try {
            $vInstanciaModelo=new MCoreGestionRemesa;
            $vRespuesta=$vInstanciaModelo->fnModificarFormularioEmision($request);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        echo json_encode($vRespuesta);
    }
    public function fnValidacionEmision($pCdProcesoTecnico){
        $vRespuesta='';
        try {
            $vInstanciaProcesos= new MCoreProcesoTecnico ;
            $vRespuesta=$vInstanciaProcesos->fnCustomQuery(array('cd_proceso_tecnico'=>$pCdProcesoTecnico),'vValidarProcesoTecnico');
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRespuesta;
    }

    function fnProcesoTecnicoCampania($pCdProcesoTecnico,$pCondicion){
        $vRetorno=0;
        try {
            $vCdUsuario=Session::get('user')['cd_usuario'];
            $vInstanciaProcesoTecnico=new MCoreProcesoTecnico;
            $vInstanciaOrdenes=new MCoreOrdenes;
            $vParametros=array();
            $vParametrosGestion=array();
            $vParametrosOrdenes=array();
            $vReemplazo='';
            $vReemplazoGestion='';
            $vConstante='vActualizarProcesoTecnicoEmision';
            $vConstanteGestion='vActualizarGestionRemesaDeProcesoTecnicoEmision';
            if($pCondicion==1){
                $vParametros=array(
                    'cd_proceso_campania'=>$pCdProcesoTecnico,
                    'in_valor'=>1
                );
                $vReemplazo='in_solicitud_seguros';
                $vParametrosGestion=array(
                    'cd_proceso_campania'=>$pCdProcesoTecnico,
                    'in_valor'=>1,
                );//
                $vReemplazoGestion='in_envio_solicitud_seguros';
                $vParametrosOrdenes=array(
                    'parametro1'=>$pCdProcesoTecnico,
                    'parametro2'=>'',
                    'parametro3'=>'',
                    'cd_programa'=>'12',
                    'tx_funcion_programa'=>'Solicitud de Seguros Campania',
                    'cd_cola'=>'20',
                    'cd_usuario'=>$vCdUsuario,
                    
                );
            }
            if($pCondicion==2){
                $vParametros=array(
                    'cd_proceso_campania'=>$pCdProcesoTecnico,
                    'in_valor'=>99
                );
                $vReemplazo='in_emision';
                $vParametrosGestion=array(
                    'cd_proceso_campania'=>$pCdProcesoTecnico,
                    'in_valor'=>1,
                );
                $vReemplazoGestion='in_valida_emision';
                $vParametrosOrdenes=array(
                    'parametro1'=>$pCdProcesoTecnico,
                    'cd_programa'=>'13',
                    'tx_funcion_programa'=>'Emision Masiva Campania',
                    'cd_cola'=>'10',
                    'cd_usuario'=>$vCdUsuario
                );
            }
            if($pCondicion==3){
                $vParametros=array(
                    'cd_proceso_campania'=>$pCdProcesoTecnico,
                    'in_valor'=>1
                );
                $vReemplazo='in_cuadro_poliza';
                $vParametrosGestion=array(
                    'cd_proceso_campania'=>$pCdProcesoTecnico,
                    'in_valor'=>1,
                );
                $vReemplazoGestion='in_envio_cuadro_poliza';
                $vParametrosOrdenes=array(
                    'parametro1'=>$pCdProcesoTecnico,
                    'cd_programa'=>'14',
                    'tx_funcion_programa'=>'Envío Cuadro Póliza Campania',
                    'cd_cola'=>'20',
                    'cd_usuario'=>$vCdUsuario
                );
            }
            
            if(sizeof($vParametrosOrdenes)>0){
                $vInstanciaOrdenes->fnAgregar($vParametrosOrdenes);
            }
            $vInstanciaProcesoTecnico->fnCustomUpdate($vParametros,$vConstante,$vReemplazo);
            $vInstanciaProcesoTecnico->fnCustomUpdate($vParametrosGestion,$vConstanteGestion,$vReemplazoGestion);
            $vRetorno=1;


        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vRetorno;
    }
    public function fnBuscarEstatusOrden($pCdProcesoTecnico){
        $vRespuesta='';
        try {
            $vInstanciaProcesos= new MCoreProcesoTecnico ;
            $vRespuesta=$vInstanciaProcesos->fnCustomQuery(array('cd_proceso_tecnico'=>$pCdProcesoTecnico),'vEstatusOrdenEmision');
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRespuesta[0]['st_orden'];
    }
    function fnDescargarLogEmision($pCdProcesoTecnico){
        
        try {
            $vNombreArchivo='LOG-EMISION-COD#-'.$pCdProcesoTecnico.'.csv';
            $vTextoArchivo='Documento;Error'.PHP_EOL;
            $vInstanciaProcesos= new MCoreProcesoTecnico ;
            $vRespuesta=$vInstanciaProcesos->fnCustomQuery(array('cd_proceso_tecnico'=>$pCdProcesoTecnico),'vLogEmision');
            if(sizeof($vRespuesta)>0){
                for($indice=0;$indice< sizeof($vRespuesta);$indice++) {
                    $vTextoArchivo.=$vRespuesta[$indice]['cd_dato'].';'.$vRespuesta[$indice]['tx_log'].''.PHP_EOL;
                }
            }else{
                $vTextoArchivo.='000;El proceso culmino con éxito.';
            }
            $vDirectorio=Constantes::entradaArchivos.$vNombreArchivo;
            File::put($vDirectorio,$vTextoArchivo,true);
            $vCabecera = array(
                  'Content-Type: application/pdf',
                );
            return Response::download($vDirectorio, $vNombreArchivo, $vCabecera);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}
