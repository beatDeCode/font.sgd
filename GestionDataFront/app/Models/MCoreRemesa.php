<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Carbon\Carbon;
use CustomQuerysRemesa;

class MCoreRemesa extends Model{
    protected $table="coreremesa";
    protected $attributes  =['st_validacion_ivss'=>0,'st_validacion_nombre'=>0,'nu_registros_cargados'=>1,
    'nu_registros_estimados'=>1,'st_remesa'=>0];
    protected $primaryKey='cd_usuario';
    public $timestamps = false;
    public $incrementing=false;
    protected $fillable=["st_validacion_ivss",
    "st_validacion_nombre",
    "tx_log_remesa",
    "nu_registros_cargados",
    "nu_registros_estimados",
    "nm_remesa",
    "cd_usuario",
    "st_remesa",
    "fe_remesa",
    "cd_producto",
    "cd_aliado",
    "cd_remesa",
    "nu_consecutivo_remesa"];
    static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select coreremesa_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }
    static function fnRetornarConsecutivoRemesa($pCdAliado){
        $vBusqueda='select count(nu_consecutivo_remesa)+1 consecutivo from coreremesa
        where cd_aliado=?';
    	$vConsecutivoAliado=DB::select($vBusqueda,[$pCdAliado]);
    	return $vConsecutivoAliado[0]->consecutivo;
    }
	public function fnListarRemesas(){
        $vTransaccion='';
        try {
        	$vBusqueda="SELECT 
				    cd_remesa,nu_consecutivo_remesa, to_char(fe_remesa,'dd/mm/yyyy') fe_registro,nm_remesa, cd_usuario, 
				    (SELECT de_producto from producto where cd_producto=core.cd_producto) de_producto,
				    (SELECT de_dato from tablainformacion where cd_tabla=410094 and va_dato1=core.cd_aliado) de_aliado,
				     nu_registros_estimados,
				    ((select count(1) from coregestionremesa where cd_remesa=core.cd_remesa )+1) *100 / nu_registros_estimados  po_progreso,
				    st_remesa
				FROM coreremesa core
				where st_remesa<4
                and (select count(1) from coregestionremesa where cd_remesa=core.cd_remesa and cd_proceso_tecnico is null )>0
                order by cd_remesa desc";
            $vTransaccion=DB::select($vBusqueda);
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }
    public function fnAgregar($request,$pDirectorio,$pNombreArchivo){
        $vRetornoArregloOrden=array();
        try {
            $vCdUsuario=Session::get('user')['cd_usuario'];
            $vSecuenciaRemesa=$this->fnRetornarSecuencia();
            $vConsecutivoAliado= $this->fnRetornarConsecutivoRemesa($request->post('cd_aliado'));
            $request->request->add(['cd_usuario'=> $vCdUsuario ]);
            $request->request->add(['fe_remesa'=> Carbon::now()->format('Y/m/d')]);
            $request->request->add(['cd_remesa'=>$vSecuenciaRemesa ]);
            $request->request->add(['nu_consecutivo_remesa'=> $vConsecutivoAliado
               ]);
            $request->request->add(['nm_remesa'=> 'TESTING1']);
            $vRetornoInsercion=$this->create(
                $request->except(['_token_md','nombreController_cd','tx_archivo','txarchivo'])
            );
            $vRetornoOperacion=array(
                'cd_cola'=>$request->post('cd_cola'),
                'tx_funcion_programa'=>$request->post('tx_funcion_programa'),
                'cd_programa'=>$request->post('cd_programa'),
                'parametro1'=>$request->post('cd_aliado'),
                'parametro2'=>$request->post('cd_producto'),
                'parametro3'=>$vSecuenciaRemesa,
                'cd_usuario'=>$vCdUsuario,
                'tx_directorio_descarga'=>$pDirectorio,
                'tx_nombre_archivo'=>$pNombreArchivo,
            );
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
    public function fnCustomQuery($pParametros, $pConstante){
        $vTransaccion='';
        try {
            
            $vBusqueda= constant(CustomQuerysRemesa::class."::".$pConstante);
            $vTransaccion=$vTransaccion=DB::select($vBusqueda,$pParametros);
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }
    public function fnCustomUpdate($pParametros,$pConstante){
        $vTransaccion='';
        try {
            DB::beginTransaction();
            $vBusqueda= constant(CustomQuerysRemesa::class."::".$pConstante);
            $vTransaccion=DB::statement($vBusqueda,$pParametros);
            DB::commit();
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }
    public function fnCustomQueryParaSelects($pParametros, $pConstante){
        $vTransaccion='';
        try {
            $vBusqueda= constant(CustomQuerysRemesa::class."::".$pConstante);
            $vTransaccion=$vTransaccion=DB::select($vBusqueda,$pParametros);
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }


}
