<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\core\AutenticacionController;
use App\Http\Controllers\core\CrudController;
use App\Http\Controllers\logica\UsuariosController;
use App\Http\Controllers\logica\ParametrosController;
use App\Http\Controllers\logica\ExpresionesCorreoController;
use App\Http\Controllers\logica\RangosEdadesController;
use App\Http\Controllers\negocio\RemesaController;
use App\Http\Controllers\negocio\NombresCompuestosController;
use App\Http\Controllers\negocio\ProcesosTecnicosController;
use App\Http\Controllers\negocio\CampaniaController;
use App\Http\Controllers\negocio\VariablesCampaniaController;
use App\Http\Controllers\logica\VariablesAnexoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/sgd.inicio', [AutenticacionController::class, 'fnIndex'])->name('sgd-inicio');
Route::post('/sgd.login', [AutenticacionController::class, 'fnInicioSesion']);
Route::get('/sgd.login.recuperacion',[AutenticacionController::class, 'fnIndiceCambioClave']);
Route::post('/sgd.login.cambio-clave',[AutenticacionController::class, 'fnCambioClave']);
Route::get('/sgd.sesion.validar',[AutenticacionController::class, 'fnValidarSesion']);
Route::get('/sgd.sesion.cerrar',[AutenticacionController::class, 'fnCierraSession']);


Route::middleware(['autorizacion.defecto'])->group(function () {
	Route::get('/sgd.inicio.menu',[AutenticacionController::class, 'fnMenuInicial'])->name('sgd-menu');
	
	Route::get('/sgd.listar.datatable/{nombreModelo}',[CrudController::class, 'fnListarPorModelos']);
	Route::get('/sgd.listar.select/{nombreModelo}',[CrudController::class, 'fnListarSelects']);
	Route::post('/sgd.agregar',[CrudController::class, 'fnAgregar']);
	Route::post('/sgd.actualizar',[CrudController::class, 'fnActualizar']);
	Route::post('/sgd.eliminar',[CrudController::class, 'fnEliminar']);
	Route::get('/sgd.listar.porId/{nombreModelo}/{pId}',[CrudController::class, 'fnListarPorModelosEIds']);
	Route::get('/sgd.listar.select-custom/{nombreModelo}',[CrudController::class, 'fnCustomQueryParaSelects']);
	
	Route::get('/sgd.configurar.usuarios',[UsuariosController::class, 'fnIndex']);
	Route::get('/sgd.configurar.variables-anexo',[VariablesAnexoController::class, 'fnIndex']);
	Route::get('/sgd.configurar.parametros',[ParametrosController::class, 'fnIndex']);
	Route::get('/sgd.configurar.expresionescorreo',[ExpresionesCorreoController::class, 'fnIndex']);
	Route::get('/sgd.configurar.ordenes',[OrdenesController::class, 'fnIndex']);

	Route::get('/sgd.configurar.rangos-edades/{pCdAliado}',[RangosEdadesController::class, 'fnIndex']);
	Route::post('/sgd.rangos-edades.agregar',[RangosEdadesController::class, 'fnAgregar']);
	Route::get('/sgd.rangos-edades.eliminar/{pCdRangoEdad}',[RangosEdadesController::class, 'fnEliminar']);

	Route::get('/sgd.remesa.carga',[RemesaController::class, 'fnCargaIndex']);
	Route::get('/sgd.remesa.listar',[RemesaController::class, 'fnListarRemesas']);
	Route::post('/sgd.remesa.agregar',[RemesaController::class, 'fnAgregarRemesa']);
	Route::get('/sgd.remesa.resumen',[RemesaController::class,'fnResumenRemesa']);
	Route::get('/sgd.remesa.data-optima/{pCdRemesa}',[RemesaController::class,'fnResumenTablaDataOptima']);
	Route::get('/sgd.remesa.data-no-optima/{pCdRemesa}',[RemesaController::class,'fnResumenTablaDataNoOptima']);
	Route::get('/sgd.remesa.detalle/{pCdRemesa}',[RemesaController::class,'fnDetalleRemesa']);
	Route::get('/sgd.remesa.procesos-tecnicos/{pCdRemesa}',[RemesaController::class,'fnResumenTablaProcesosTecnicos']);
	Route::get('/sgd.remesa.porcentajes-edad/{pCdRemesa}/{pCdRango}',[RemesaController::class,'fnPorcentajesDataOptimaRangoEdad']);
	Route::get('/sgd.remesa.porcentajes-global/{pCdRemesa}',[RemesaController::class,'fnPorcentajesDataGlobal']);
	Route::get('/sgd.remesa.porcentajes-data-optima/{pCdRemesa}',[RemesaController::class,'fnPorcentajesDataOptima']);
	Route::get('/sgd.remesa.porcentajes-data-nooptima/{pCdRemesa}',[RemesaController::class,'fnPorcentajesDataNoOptima']);
	Route::get('/sgd.remesa.nombres-compuestos/{pCdRemesa}',[NombresCompuestosController::class,'fnIndex']);
	Route::post('/sgd.remesa.nombres-compuestos.agregar',[NombresCompuestosController::class,'fnAgregar']);
	Route::get('/sgd.remesa.balance-basico/{pCdRemesa}',[RemesaController::class,'fnBalanceRemesa']);
	Route::get('/sgd.remesa.formulario-data/{pNuDocumento}',[RemesaController::class,'fnFomularioModificacionData']);
	Route::post('/sgd.remesa.actualizar-formulario-data',[RemesaController::class,'fnActualizarFormularioModificacionData']);

	Route::get('/sgd.proceso-tecnico.agregar/{pCdRemesa}/{pCdRangoEdad}/{pMtSuma}/{pPoComercial}/{pCantidadRegistros}',[RemesaController::class, 'fnProcesoTecnico']);
	Route::get('/sgd.proceso-tecnico.actualizar/{pCdProcesoTecnico}/{pCondicion}',[ProcesosTecnicosController::class,'fnActualizarProcesoTecnico']);
	Route::get('/sgd.proceso-tecnico.formulario-emision/{pNuDocumento}',[ProcesosTecnicosController::class,'fnFomularioEmision']);
	Route::post('/sgd.proceso-tecnico.actualizar-formulario-emision',[ProcesosTecnicosController::class,'fnActualizarFormularioEmision']);
	Route::get('/sgd.proceso-tecnico.valida-emision/{pCdProcesoTecnico}',[ProcesosTecnicosController::class,'fnValidacionEmision']);
	Route::get('/sgd.proceso-tecnico.status-emision/{pCdProcesoTecnico}',[ProcesosTecnicosController::class,'fnBuscarEstatusOrden']);
	Route::get('/sgd.proceso-tecnico.log-emision/{pCdProcesoTecnico}',[ProcesosTecnicosController::class,'fnDescargarLogEmision']);


	Route::get('/sgd.campania.resumen',[CampaniaController::class,'fnResumenCampania']);
	Route::get('/sgd.campania.detalle/{pCdRemesa}',[CampaniaController::class,'fnDetalleCampania']);
	Route::get('/sgd.campania.panel-general/{pCdCampania}/{pCdProcesoTecnico}',[CampaniaController::class,'fnResumenPanelGeneral']);
	Route::get('/sgd.campania.panel-por-intentos/{pCdCampania}/{pCdProcesoTecnico}',[CampaniaController::class,'fnResumenPanelPorIntentos']);
	Route::get('/sgd.campania.formulario-campania/{pNuDocumento}',[CampaniaController::class,'fnFormularioCampania']);
	Route::get('/sgd.campania.buscar-variables-subniveles/{pCdNivel}/{pCdRelacion}',[CampaniaController::class,'fnBuscarSubniveles']);
	Route::get('/sgd.campania.cerrar/{pCdCampania}/{pCdProcesoTecnico}',[CampaniaController::class,'fnCierreDeCampania']);
	Route::get('/sgd.campania.cerrar-contacto/{pCdCampania}/{pCdProcesoTecnico}/{nuConsecutivo}',[CampaniaController::class,'fnCierreContacto']);
	Route::post('/sgd.campania.actualizar-formulario-campania',[CampaniaController::class,'fnCargaCampania']);
	Route::get('/sgd.campania.listar-porremesas/{pCdRemesa}',[CampaniaController::class,'fnListadosDeCampaniasPorRemesa']);
	Route::get('/sgd.campania.buscar-parentesco',[CampaniaController::class,'fnBuscarParentescos']);


	Route::get('/sgd.campania.variables-de-cierre/{pCdParametro}/{pCdVariable}',[VariablesCampaniaController::class,'fnAgregarVariableDeCierre']);
	Route::get('/sgd.campania.buscar-formulario-tecnico/{pCdVariable}',[VariablesCampaniaController::class,'fnBuscarFormularioTecnico']);
	Route::get('/sgd.campania.buscar-suma-asegurada/{pCdVariable}/{pCdCampania}',[VariablesCampaniaController::class,'fnBuscarSumaAsegurada']);
	Route::get('/sgd.campania.buscar-adicionales',[VariablesCampaniaController::class,'fnBuscarAdicionales']);
	

	Route::get('/sgd.campania.descargar-campania/{pCdCampania}/{pCdProcesoTecnico}/{pCdVariable}',[CampaniaController::class,'fnDescargarArchivoCampaniaPorVariablePrimerNivel']);
	Route::get('/sgd.campania.variables/{pNivel}',[VariablesCampaniaController::class,'fnIndice']);
	Route::get('/sgd.campania.variables-eliminar/{pCdVariable}',[VariablesCampaniaController::class,'fnEliminar']);
	Route::post('/sgd.campania.variables-agregar',[VariablesCampaniaController::class,'fnAgregar']);
	
	
	Route::get('/sgd.campania.estadisticas',[CampaniaController::class,'fnIndiceEstadisticas']);
	Route::get('/sgd.campania.estadisticas-generales/{pCdCampania}/{pCdProcesoTecnico}',[CampaniaController::class,'fnEstadisticasGenerales']);
	Route::get('/sgd.campania.estadisticas-variable0/{pCdCampania}/{pCdProcesoTecnico}',[CampaniaController::class,'fnEstadisticasVariable0']);
	Route::get('/sgd.campania.estadisticas-por-usuario/{pCdCampania}/{pCdVariable}',[CampaniaController::class,'fnEstadisticasPorUsuario']);
	Route::get('/sgd.campania.estadisticas-por-contacto/{pCdCampania}/{pCdVariable}',[CampaniaController::class,'fnEstadisticasPorContacto']);
	
	Route::get('/sgd.campania-emision.resumen',[CampaniaController::class,'fnResumenCampaniaEmision']);
	//Route::get('/sgd.campania.emision-detalle/{pCdCampania}',[CampaniaController::class,'fnDetalleCampaniaEmision']);

	Route::get('/sgd.campania.emision-listar-proceso-por-campanias/{pCdCampania}',[CampaniaController::class,'fnListadosDeCampaniasProcesos']);
	Route::get('/sgd.campania.emision-detalle-proceso-campanias/{pCdProcesoCampania}/{pCdCampania}',[CampaniaController::class,'fnDetalleProcesoCampania']);
	
	Route::get('/sgd.campania.emision-panel-general/{pCdProcesoCampania}/{pCdCampania}',[CampaniaController::class,'fnResumenPanelGeneralEmision']);
	
	Route::get('/sgd.campania.emision.actualizar/{pCdProcesoTecnico}/{pCondicion}',[ProcesosTecnicosController::class,'fnProcesoTecnicoCampania']);
	

	
	
});


