<?php

namespace App\Http\Controllers\negocio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MCoreCampania;
use App\Models\MCoreProcesoCampania;
use App\Models\MCoreGestionCampania;
use App\Models\MCoreGestionRemesa;
use App\Models\MCoreGestionAdicionales;
use DB;
use Constantes;
use File;
use Response;
use Session;

class CampaniaController extends Controller{
    function fnResumenCampania(){
        try {
            $vMenu=512;
            $vSubmenu =513;
            $vTituloTarjeta ='Resumen de Campania';
            $vLongitudColumnas=12;  
            $vAcordiones=[
                        'Panel General de Campaña.|fnPanelGeneral|acordion-panel-general|panel-general|info|12|0'];
            $vScripts=array('negocio/campania/campania-objetos.js','buslogic/core.js','negocio/campania/panel-campania.js');
            $vInstanciaCampania= new MCoreCampania;
            $vOptionsRemesas=$vInstanciaCampania->fnCustomQuery(array(),'vListaRemesasParaCampanias');
            return view('negocio.campania.campania-resumen-principal', compact(
                'vMenu','vSubmenu','vTituloTarjeta','vLongitudColumnas','vScripts','vAcordiones','vOptionsRemesas'
            ));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function fnListadosDeCampaniasPorRemesa($pCdRemesa){
        $vInstanciaCampania= new MCoreCampania;
        return
        $vOptionsRemesas=$vInstanciaCampania->fnCustomQuery(array('cd_remesa'=>$pCdRemesa),'vListaDeCampanias');
    }

    function fnResumenPanelGeneral($pCdCampania,$pCdProcesoTecnico){
        $vRetornoData=[];
        try {
            $vInstanciaCampania=new MCoreCampania;
            $vRetornoData=$vInstanciaCampania->fnCustomQuery(array('cd_campania'=>$pCdCampania,'cd_proceso_tecnico'=>$pCdProcesoTecnico),'vPanelGeneralEstadisticoCampanias');

        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }

    function fnResumenPanelPorIntentos($pCdCampania,$pCdProcesoTecnico){
        $vRetornoData=[];
        try {
            $vInstanciaCampania=new MCoreCampania;
            $vRetornoData=$vInstanciaCampania->fnCustomQuery(array('cd_campania'=>$pCdCampania,'cd_proceso_tecnico'=>$pCdProcesoTecnico),'vPanelPorIntentos');

        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }

    function fnDetalleCampania($pCdCampania){
        $vRetornoData=[];
        try {
            
            $vInstanciaCampania=new MCoreCampania;
            $vRetornoData=$vInstanciaCampania->fnCustomQuery(array('cd_campania'=>$pCdCampania),'vDetalleCampania');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }

    function fnFormularioCampania($pNuDocumento){
    	$vClientes=array();
        $vNiveles=array();
        $vVariables=array();
        $vOptionsSumaAsegurada=array();
        $vOptionsTpDocumento=array();
        $vOptionsTpSexo=array();
        $vOptionsTpEstadoCivil=array();
        $vBuscarDetalleContactosClientePorDocumento=array();
        $vCantidadContactosPorDocumento='0';
        $vGruposFamiliares=array();
        $vDatosModificadosCliente=array();
        $vAdicionalesPorDocumento=array();
        try {
        	if($pNuDocumento=='$AL'){}else{
                
                $vInstanciaCampania= new MCoreCampania ;
                $vCantidadContactosPorDocumento=$vInstanciaCampania->fnCustomQuery(array('nu_documento'=>$pNuDocumento),'vCantidadContactosPorDocumento');
                $vBuscarDetalleContactosClientePorDocumento=$vInstanciaCampania->fnCustomQuery(array('nu_documento'=>$pNuDocumento),'vBuscarDetalleContactosClientePorDocumento');
                $vDatosModificadosCliente=$vInstanciaCampania->fnCustomQuery(array('nu_documento'=>$pNuDocumento),'vListaDetalleDataCampania');
        		$vClientes=$vInstanciaCampania->fnCustomQuery(array('nu_documento'=>$pNuDocumento),'vClientePorDocumento');
                $vGruposFamiliares=$vInstanciaCampania->fnCustomQuery(array(),'vBuscarGruposFamiliaresPorSuma');
                $vNiveles=$vInstanciaCampania->fnCustomQuery(array(),'vNivelesDeVariablesCallCenter');
                $vVariables=$vInstanciaCampania->fnCustomQuery(array(),'vVariablesCallCenter');
                $vOptionsTpDocumento=$vInstanciaCampania->fnCustomQuery(array(),'vTiposDocumentos');
                $vOptionsSumaAsegurada=$vInstanciaCampania->fnCustomQuery(array(),'vSumasAseguradas');
                $vOptionsTpSexo=$vInstanciaCampania->fnCustomQuery(array(),'vTiposSexos');
                $vOptionsTpEstadoCivil=$vInstanciaCampania->fnCustomQuery(array(),'vTiposEstadosCiviles');

                $vAdicionalesPorDocumento=$vInstanciaCampania->fnCustomQuery(array('nu_documento'=>$pNuDocumento),'vAdicionalesPorDocumento');
        	}
            $vMenu=512;
            $vSubmenu =514;
            $vLongitudColumnas='12';
            $vTituloTarjeta ='Formulario de Contacto del Cliente.';
            $vScripts=array('buslogic/core.js','negocio/campania/formulario-campania.js');
            return view('negocio.campania.formulario-campania', compact(
                'vMenu','vSubmenu','vTituloTarjeta','vScripts','vOptionsSumaAsegurada','vOptionsTpDocumento',
                    'vLongitudColumnas','vClientes','vNiveles','vVariables','vOptionsTpSexo','vOptionsTpEstadoCivil','vCantidadContactosPorDocumento','vBuscarDetalleContactosClientePorDocumento','vGruposFamiliares','vDatosModificadosCliente','vAdicionalesPorDocumento'
            ));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    function fnBuscarSubniveles($pNivel,$pCdRelacion){
        $vRetornoData=[];
        try {
            
            $vInstanciaCampania=new MCoreCampania;
            $vRetornoData=$vInstanciaCampania->fnCustomQuery(array('nu_nivel'=>$pNivel,'cd_relacion'=>$pCdRelacion),'vBuscarSubNivelesCallCenter');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }

    function fnCierreDeCampania($pCdCampania,$pCdProcesoTecnico){
        $vRetornoData=[];
        try {
            $vInstanciaCampania=new MCoreCampania;
            $vInstanciaCampania->fnCustomUpdate(array('cd_campania'=>$pCdCampania),'vActualizarCampania');
            $vInstanciaCampania->fnCustomUpdate(array('cd_proceso_tecnico'=>$pCdProcesoTecnico),'vActualizarProcesoDeCampania');
            $vRetornoData=1;
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }

    function fnCierreContacto($pCdCampania,$pCdProcesoTecnico,$pNuConsecutivo){
        $vRetornoData=[];
        try {
            $vInstanciaCampania=new MCoreCampania;
            
            $vVariableDeCierre=$vInstanciaCampania->fnCustomQuery(array('cd_tabla'=>'CC_VARIABLE_NC'),'vValorParametro');
            $vPorcentajeComercialCampania=$vInstanciaCampania->fnCustomQuery(array('cd_proceso_tecnico'=>$pCdProcesoTecnico),'vPorcetajeComercialCampania');
            
            if($vPorcentajeComercialCampania[0]['po_descuento']<100){
                $vInstaciaProcesoCampania=new MCoreProcesoCampania;
                $vCampaniaProceso=$vInstaciaProcesoCampania->fnAgregar($pCdCampania,$pNuConsecutivo);
                $vInstaciaProcesoCampania->fnCustomUpdate(
                        array(
                            
                            'cd_campania'=>$pCdCampania,
                            'cd_proceso_campania'=>$vCampaniaProceso->cd_proceso_campania
                        ),
                    'vActualizarProcesoCampaniaEnRemesa');
            }

            $vInstanciaCampania->fnCustomUpdate(array('cd_campania'=>$pCdCampania),'vActualizarConsecutivoCampania');
            $vBusquedaGestionesSinContactar='vBuscarRegistrosSinContactarConsecutivo1';
            if($pNuConsecutivo>1){
                $vBusquedaGestionesSinContactar='vBuscarRegistrosSinContactarConsecutivoMayorA1';
            }
            $vRecorridoDeRegistrosSinGestionar=$vInstanciaCampania->fnCustomQuery(
                array('cd_campania'=>$pCdCampania,'nu_consecutivo'=>$pNuConsecutivo,'cd_proceso_tecnico'=>$pCdProcesoTecnico),
                $vBusquedaGestionesSinContactar);
            $vInstanciaGestionCampania=new MCoreGestionCampania;
            $vVariable=$vVariableDeCierre[0]['value'];
            $vVariableRelacionadaDeCierre=$vInstanciaCampania->fnCustomQuery(array('cd_variable'=>$vVariable),'vBuscarVariableRelacionada');
            $vVariableRelacion=$vVariableRelacionadaDeCierre[0]['value'];
            foreach($vRecorridoDeRegistrosSinGestionar as $vGestion){
                $vArrayParaInsertar=array('cd_gestion_remesa'=>$vGestion['cd_gestion_remesa'],'cd_variable0'=>$vVariableRelacion,'cd_variable1'=>$vVariable,'cd_campania'=>$pCdCampania);
                $vInstanciaGestionCampania->fnAgregar($vArrayParaInsertar);
            }
            $vRetornoData=1;
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }

    function fnCargaCampania(Request $request){
        $vInstanciaGestionRemesa=new MCoreGestionRemesa;
        $vInstanciaGestionCampania=new MCoreGestionCampania;
        $vInstanciaAdicionales=new MCoreGestionAdicionales;
        $vRetorno="";
        try {
            $vRetorno=$vInstanciaGestionRemesa->fnModificarFormularioCampania($request,$request->post('co_adicionales'));
            $vEstatusGestionCampania=null;
            if($vRetorno=='1'){
                $vBusquedaDecisionFinalVariable=$vInstanciaGestionCampania->fnRetornaDecisionFinalVariable($request->post('cd_variable1'));
                if($vBusquedaDecisionFinalVariable==1){
                    $vEstatusGestionCampania=1;
                }
                $vSolicitudGestionCampania=array(
                    'cd_gestion_remesa'=>$request->post('cd_gestion_remesa'),
                    'cd_variable0'=>$request->post('cd_variable0'),
                    'cd_variable1'=>$request->post('cd_variable1'),
                    'cd_variable2'=>$request->post('cd_variable2'),
                    'cd_variable3'=>$request->post('cd_variable3'),
                    'cd_variable4'=>$request->post('cd_variable4'),
                    'cd_variable5'=>$request->post('cd_variable5'),
                    'cd_variable6'=>$request->post('cd_variable6'),
                    'cd_variable7'=>$request->post('cd_variable7'),
                    'cd_grupo_familiar'=>$request->post('co_grupo_familiar'),
                    'cd_suma_asegurada'=>$request->post('co_suma_asegurada'),
                    'cd_adicionales'=>$request->post('co_adicionales'),
                    'cd_campania'=>$request->post('cd_campania'),
                    'st_gestion_campania'=>$vEstatusGestionCampania
                );
                $vInstanciaGestionCampania->fnAgregar($vSolicitudGestionCampania);
                if($request->post('co_adicionales')>0){
                    for($indice=0;$indice<$request->post('co_adicionales');$indice++){
                        $vSolicitudAdicionales=array();
                        $vSolicitudAdicionales=array(
                            'cd_gestion_remesa'=>$request->post('cd_gestion_remesa'),
                            'nu_area'=>$request->post('ad_nu_area'.$indice),
                            'nu_telefono'=>$request->post('ad_nu_telefono'.$indice),
                            'tp_documento'=>$request->post('ad_tp_documento'.$indice),
                            'nu_documento'=>$request->post('ad_nu_documento'.$indice),
                            'cd_parentesco'=>$request->post('ad_cd_parentesco'.$indice),
                            'fe_nacimiento'=>$request->post('ad_fe_nacimiento'.$indice)
                        );
                    $vInstanciaAdicionales->fnAgregar($vSolicitudAdicionales);
                    }
                }
                
            }
        } catch (Exception $e) {
            
        }
        return $vRetorno;
    }
    function fnDescargarArchivoCampaniaPorVariablePrimerNivel($pCdCampania,$pCdProcesoTecnico,$pCdVariable){
        
        try {
            $vInstanciaCampania=new MCoreCampania;
            
            $vQuery='vListadoDeContactosPorVariables';
            if($pCdVariable==0){
                $vQuery='vListadoDeContactosSinGestionar';
                $vNombreArchivo='CAMPANIA-COD#-'.$pCdCampania.'-Sin Gestionar.csv';
            }else{
                $vNombreArchivo='CAMPANIA-COD#-'.$pCdCampania.'-'.$vInstanciaCampania->fnBuscarNombreDeVariable($pCdVariable).'.csv';
            }
            $vListadoContactosPorVariable=
                $vInstanciaCampania->fnCustomQuery(
                    array('cd_campania'=>$pCdCampania, 'cd_proceso_tecnico'=>$pCdProcesoTecnico,'cd_variable'=>$pCdVariable),
                    $vQuery
                );
            $vTextoArchivo='Telefono;Nombre'.PHP_EOL;
            
            if(sizeof($vListadoContactosPorVariable)>0){
                for($indice=0;$indice< sizeof($vListadoContactosPorVariable);$indice++) {
                    $vTextoArchivo.=$vListadoContactosPorVariable[$indice]['valor'].PHP_EOL;
                }
            }else{
                $vTextoArchivo='No existen Registros para la variable solicitada.';
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
    public function fnIndiceEstadisticas(){
        try {
            $vInstanciaCampania=new MCoreCampania;
            $vMenu=512;
            $vSubmenu =517;
            $vLongitudColumnas='12';
            $vTituloTarjeta ='Variables para Formulario de Campaña.';
            
            $vOptionsNiveles=$vInstanciaCampania->fnCustomQuery(array('cd_tabla'=>'PR_NIVELES'),'vListarParametros');
            $vOptionsRemesas=$vInstanciaCampania->fnCustomQuery(array(),'vListaRemesas');
            $vOptionsVariables=$vInstanciaCampania->fnCustomQuery(array('nu_nivel'=>1),'vListarVariablesPorNivelSelect');
            $vScripts=array('chartjs/Chart.min.js','chartjs/utils.js','chartjs/chartjs-plugin.js','buslogic/core.js','negocio/campania/campania-objetos.js','negocio/campania/campania-estadisticas.js');

            return view('negocio.campania.campania-estadisticas', compact(
                'vMenu','vSubmenu','vLongitudColumnas','vTituloTarjeta','vScripts','vOptionsRemesas','vOptionsVariables','vOptionsNiveles'
            ));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function fnEstadisticasGenerales($pCdCampania,$pCdProcesoTecnico){
        $vArrayEstadisticas=array();
        $vInstanciaCampania=new MCoreCampania;
        $vDistribucionCampania=$vInstanciaCampania->fnCustomQuery(array('cd_campania'=>$pCdCampania,'cd_proceso_tecnico'=>$pCdProcesoTecnico),'vPanelGeneralEstadisticoCampanias');

        return $vDistribucionCampania;
    }
    public function fnEstadisticasVariable0($pCdCampania,$pCdProcesoTecnico){
        $vArrayEstadisticas=array();
        $vInstanciaCampania=new MCoreCampania;
        $vDistribucionCampania=$vInstanciaCampania->fnCustomQuery(array('cd_campania'=>$pCdCampania,'cd_proceso_tecnico'=>$pCdProcesoTecnico),'vPanelGeneralEstadisticoVariable0');
        
        return $vDistribucionCampania;
    }
    public function fnEstadisticasPorUsuario($pCdCampania,$pCdVariable){
        $vArrayEstadisticas=array();
        $vInstanciaCampania=new MCoreCampania;
        $vDistribucionCampaniaPorUsuarios=$vInstanciaCampania->fnCustomQuery(
            array('cd_campania'=>$pCdCampania,'cd_variable'=>$pCdVariable),'vPanelEstadisticoPorUsuario');
        return $vDistribucionCampaniaPorUsuarios;
    }
    public function fnEstadisticasPorContacto($pCdCampania,$pNuConsecutivo){
        $vArrayEstadisticas=array();
        $vInstanciaCampania=new MCoreCampania;
        $vDistribucionCampaniaPorUsuarios=$vInstanciaCampania->fnCustomQuery(
            array('cd_campania'=>$pCdCampania,'nu_consecutivo'=>$pNuConsecutivo),'vPanelEstadisticoPorNumeroContacto');
        return $vDistribucionCampaniaPorUsuarios;
    }
    
    

    function fnBuscarParentescos(){
        $vRetornoData=[];
        try {
            
            $vInstanciaCampania=new MCoreCampania;
            $vRetornoData=$vInstanciaCampania->fnCustomQuery(array(),'vBuscarParentescos');
        } catch (Exception $e) {
            $e->getMessage();
        }
        return $vRetornoData;
    }
    
    function fnResumenCampaniaEmision(){
        try {
            $vMenu=512;
            $vSubmenu =519;
            $vTituloTarjeta ='Resumen de Emision Campaña';
            $vLongitudColumnas=12;  
            $vAcordiones=[
                        'Panel General para Realizar Procesos Tecnico de la Campaña.|fnPanelCampaniaEmision|acordion-panel-general|panel-general|info|12|0'];
            $vScripts=array('negocio/campania/campania-objetos.js','buslogic/core.js','negocio/campania/panel-campania-emision.js');
            $vInstanciaCampania= new MCoreCampania;
            $vOptionsRemesas=$vInstanciaCampania->fnCustomQuery(array(),'vListadoCampaniasProceso');
            return view('negocio.campania.campania-emision-resumen-principal', compact(
                'vMenu','vSubmenu','vTituloTarjeta','vLongitudColumnas','vScripts','vAcordiones','vOptionsRemesas'
            ));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    function fnListadosDeCampanias(){
        $vInstanciaCampania= new MCoreCampania;
        return
        $vOptionsRemesas=$vInstanciaCampania->fnCustomQuery(array(),'vListadoCampaniasProceso');
    }

    function fnListadosDeCampaniasProcesos($pCdCampania){
        $vInstanciaCampania= new MCoreCampania;
        return
        $vOptionsRemesas=$vInstanciaCampania->fnCustomQuery(array('cd_campania'=>$pCdCampania),'vListadoProcesosTecnicosCampania');
    }
    function fnResumenPanelGeneralEmision($pCdProcesoCampania,$pCdCampania){
        $vInstanciaCampania= new MCoreCampania;
        return
        $vOptionsRemesas=$vInstanciaCampania->fnCustomQuery(array('cd_proceso_campania'=>$pCdProcesoCampania,
            'cd_campania'=>$pCdCampania,),'vPanelGeneralEmisionCampania');
    }
    function fnDetalleProcesoCampania($pCdProcesoCampania,$pCdCampania){
        $vInstanciaCampania= new MCoreCampania;
        return
        $vOptionsRemesas=$vInstanciaCampania->fnCustomQuery(array('cd_proceso_campania'=>$pCdProcesoCampania,
            'cd_campania'=>$pCdCampania,),'vDetalleProcesoCampania');
        
    }

}
