<?php

namespace App\Http\Controllers\negocio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MCoreAliadoPorProducto;
use App\Models\MCoreRemesa;
use App\Models\MCoreOrdenes;
use App\Models\MCoreProcesoTecnico;
use App\Models\MCoreGestionRemesa;
use Constantes;
use Storage;

class RemesaController extends Controller{
    function fnCargaIndex(){
    	try {
    		$vMenu=501;
    		$vSubmenu =502;
    		$vTituloTarjeta ='Carga de Remesa';
    		$vLongitudColumnas=12;	
    		$vScripts=array('buslogic/objetos.js','buslogic/core.js','negocio/remesa/remesa-carga.js');
    		$vInstanciaAliadosPorProducto= new MCoreAliadoPorProducto ;
			$vArregloParaOrden=[
				'cd_programa|1',//cd_programa
				'cd_cola|1',//cd_cola
				'tx_funcion_prgrama|Lectura y Gestión de Archivo',//tx_funcion_prgrama
			];
    		$vOptionsAliadosPermitidos=$vInstanciaAliadosPorProducto->fnAliadosPermitidos();
    		$vOptionsProductosPermitidos=$vInstanciaAliadosPorProducto->fnProductosPermitidos();
    	} catch (Exception $e) {
    		$e->getMessage();
    	}
    	return view('negocio.remesa.remesa-carga',compact('vMenu','vSubmenu','vTituloTarjeta',
		'vLongitudColumnas','vScripts','vOptionsAliadosPermitidos','vOptionsProductosPermitidos',
		'vArregloParaOrden'));
    }
    function fnListarRemesas(){
        try {
            $vInstanciaAliadosPorProducto= new MCoreRemesa ;
            $vListadoDeRemesas=$vInstanciaAliadosPorProducto->fnListarRemesas();
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vListadoDeRemesas;
    }
	function fnAgregarRemesa(Request $request){
		try {
            $vArchivo = $request->file('txarchivo');
			$vNombreOriginalArchivo=$vArchivo->getClientOriginalName();
            $vDirectorio=Constantes::entradaArchivos;
            $vArchivo->move($vDirectorio,$vNombreOriginalArchivo);
            $vDirectorioCompleto=$vDirectorio.$vNombreOriginalArchivo;
			$vInstanciaRemesa=new MCoreRemesa;
			$vArregloParaGuardarOrden=$vInstanciaRemesa->fnAgregar($request,$vDirectorioCompleto,$vNombreOriginalArchivo);
			$vInstanciaOrden=new MCoreOrdenes;
			$vInstanciaOrden->fnAgregar($vArregloParaGuardarOrden);
		} catch (Exception $e) {
			$e->getMessage();
		}
	}

    function fnResumenRemesa(){
        try {
            $vMenu=501;
            $vSubmenu =503;
            $vTituloTarjeta ='Resumen de Remesa';
            $vLongitudColumnas=12;  
            $vAcordiones=[
                        'Data Preeliminar.|fnDataPreeliminar|acordion-data-optima|data-optima|info|6|6',
                        'Procesos Técnicos.|fnDataProcesosTecnicos|acordion-data-optima1|procesos-tecnicos|danger|12|0'];
            $vScripts=array('negocio/remesa/remesa-objetos.js','buslogic/core.js','negocio/remesa/remesa-data-preeliminar.js');
            $vInstanciaRemesa= new MCoreRemesa;
            $vOptionsRemesas=$vInstanciaRemesa->fnCustomQuery(array(),'vListaRemesas');
            return view('negocio.remesa.remesa-resumen-principal', compact(
                'vMenu','vSubmenu','vTituloTarjeta','vLongitudColumnas','vScripts','vAcordiones','vOptionsRemesas'
            ));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function fnResumenTablaDataOptima($pCdRemesa){
        $vRetornoData=[];
        try {
            $vInstanciaRemesa=new MCoreRemesa;
            $vRetornoData=$vInstanciaRemesa->fnCustomQuery(array('cd_remesa'=>$pCdRemesa,'cd_aliado'=>11,'st_gestion_remesa'=>3),'vDataOptima');

        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }
    function fnResumenTablaDataNoOptima($pCdRemesa){
        $vRetornoData=[];
        try {
            $vInstanciaRemesa=new MCoreRemesa;
            $vRetornoData=$vInstanciaRemesa->fnCustomQuery(array('cd_remesa'=>$pCdRemesa),'vDataNoOptima');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }
    function fnDetalleRemesa($pCdRemesa){
        $vRetornoData=[];
        try {
            $vInstanciaRemesa=new MCoreRemesa;
            $vRetornoData=$vInstanciaRemesa->fnCustomQuery(array('cd_remesa'=>$pCdRemesa),'vDetalleRemesa');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }
    function fnResumenTablaProcesosTecnicos($pCdRemesa){
        $vRetornoData=[];
        try {
            $vInstanciaRemesa=new MCoreRemesa;
            $vRetornoData=$vInstanciaRemesa->fnCustomQuery(array('cd_remesa'=>$pCdRemesa),'VProcesosTecnicos');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }
    function fnPorcentajesDataOptimaRangoEdad($pCdRemesa,$pCdRangoEdad){
        $vRetornoData=[];
        try {
            $vInstanciaRemesa=new MCoreRemesa;
            $vRetornoData=$vInstanciaRemesa->fnCustomQuery(array('cd_remesa'=>$pCdRemesa,'cd_rango'=>$pCdRangoEdad),'vPorcetajesDataOptimaPorRangoEdad');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }
    function fnPorcentajesDataGlobal($pCdRemesa){
        $vRetornoData=[];
        try {
            $vInstanciaRemesa=new MCoreRemesa;
            $vRetornoData=$vInstanciaRemesa->fnCustomQuery(array('cd_remesa'=>$pCdRemesa),'vPorcentajesDataGlobal');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }
    function fnPorcentajesDataOptima($pCdRemesa){
        $vRetornoData=[];
        try {
            $vInstanciaRemesa=new MCoreRemesa;
            $vRetornoData=$vInstanciaRemesa->fnCustomQuery(array('cd_remesa'=>$pCdRemesa),'vPorcentajesDataOptima');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }
    function fnPorcentajesDataNoOptima($pCdRemesa){
        $vRetornoData=[];
        try {
            $vInstanciaRemesa=new MCoreRemesa;
            $vRetornoData=$vInstanciaRemesa->fnCustomQuery(array('cd_remesa'=>$pCdRemesa),'vPorcentajesDataNoOptima');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }
    function fnProcesoTecnico($pCdRemesa,$pCdRangoEdad,$pSumaAsegurada,$pPorcentaComercial,$pCantidadRegistros){
        $vRetornoData=[];
        $vRetorno=0;
        try {
            $vInstanciaProcesoTecnico=new MCoreProcesoTecnico;
            $vArregloSolicitud=array(
                    'cd_remesa'=>$pCdRemesa,
                    'cd_rango_edad'=>$pCdRangoEdad,
                    'mt_suma_asegurada'=>$pSumaAsegurada,
                    'po_descuento'=>$pPorcentaComercial);
            $vRetornoProcesoTecnico=$vInstanciaProcesoTecnico->fnAgregar($vArregloSolicitud);
            $vInstanciaRemesa=new MCoreRemesa;
            $vParametros=array(
                    'cd_remesa'=>$vRetornoProcesoTecnico->cd_remesa,
                    'ca_registros'=>$pCantidadRegistros,
                    'cd_rango_edad'=>$pCdRangoEdad,
                    'cd_proceso_tecnico'=>$vRetornoProcesoTecnico->cd_proceso_tecnico,
                    'st_remesa'=>'4',
                    'po_comercial'=>$vRetornoProcesoTecnico->po_descuento,
                    'mt_suma_asegurada'=>$vRetornoProcesoTecnico->mt_suma_asegurada
            );
            $vRetornoData=$vInstanciaRemesa->fnCustomUpdate(
                $vParametros,'vActualizarRemesaAProcesoTecnico');
            $vRetorno=1;
        } catch (Exception $e) {
            $vRetorno=999;
            $e->getMessage();
        }
        return $vRetorno;
    }
    function fnBalanceRemesa($pCdRemesa){
        $vBalanceRemesa=array();
        try {
            $vInstanciaRemesa= new MCoreRemesa;
            $vBalanceRemesa=$vInstanciaRemesa->fnCustomQuery(array('cd_remesa'=>$pCdRemesa),'vBuscarBalanceRemesa');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vBalanceRemesa;

    }

     function fnFomularioModificacionData($pNuDocumento){
        $vClientes=array();
        $vErroresPorClientes=array();
        try {
            $vInstanciaProcesos= new MCoreProcesoTecnico ;
            $vOptionsTpDocumento=$vInstanciaProcesos->fnCustomQuery(array(),'vTiposDocumentos');
            $vOptionsTpSexo=$vInstanciaProcesos->fnCustomQuery(array(),'vTiposSexos');
            $vOptionsTpEstadoCivil=$vInstanciaProcesos->fnCustomQuery(array(),'vTiposEstadosCiviles');

            if($pNuDocumento=='$AL'){}else{
                $vClientes=$vInstanciaProcesos->fnCustomQuery(array('nu_documento'=>$pNuDocumento),'vListaDetalleDataPorDocumento');
            }
            $vMenu=501;
            $vSubmenu =520;
            $vLongitudColumnas='12';
            $vTituloTarjeta ='Formulario para Modificación de la Data.';
            $vScripts=array('buslogic/core.js','negocio/remesa/formulario-procesos.js');
            return view('negocio.remesa.formulario-modificacion-data', compact(
                'vMenu','vSubmenu','vTituloTarjeta','vScripts','vOptionsTpSexo','vOptionsTpDocumento',
                    'vOptionsTpEstadoCivil','vLongitudColumnas','vClientes','vErroresPorClientes'
            ));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
     public function fnActualizarFormularioModificacionData(Request $request){
        $vRespuesta='';
        try {
            $vInstanciaModelo=new MCoreGestionRemesa;
            $vRespuesta=$vInstanciaModelo->fnModificarFormularioEmision($request);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        echo json_encode($vRespuesta);
    }
    
}

