<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Carbon\Carbon;
use CustomQuerysRemesa;
class MCoreProcesoTecnico extends Model
{
    protected $table="coreprocesotecnico";
    protected $primaryKey='cd_proceso_tecnico';
    protected $attributes  =['in_solicitud_campania'=>0,'in_solicitud_seguros'=>0,'in_envio_cuadro_poliza'=>0,
    'in_emision_masiva'=>0];
    public $timestamps = false;
    public $incrementing=false;
    protected $fillable=[
        "cd_proceso_tecnico",
        "mt_suma_asegurada",
        "po_descuento",
        "in_solicitud_campania",
        "cd_usuario",
        "max_edad",
        "cd_remesa",
        "in_solicitud_seguros",
        "in_envio_cuadro_poliza",
        "in_emision_masiva",
        "fe_proceso",
        "min_edad",
    ];
    static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select coreprocesotecnico_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }

    static function fnRetornaMaxMinEdad($vCdRangoEdad){
    	$vSecuencia=DB::select('select min_edad, max_edad 
                from corereporteedad where cd_rango_edad=:cd_rango_edad',[':cd_rango_edad'=>$vCdRangoEdad]);
    	return $vSecuencia[0];
    }
    public function fnAgregar($request){
        $vRetornoArregloOrden=array();
        try {
            $vCdUsuario=Session::get('user')['cd_usuario'];
            $vSecuenciaProcesoTecnico=$this->fnRetornarSecuencia();
            $vRangoEdad=$this->fnRetornaMaxMinEdad( $request['cd_rango_edad']);
            $request['cd_usuario']=$vCdUsuario;
            $request['cd_proceso_tecnico']=$vSecuenciaProcesoTecnico;
            $request['fe_proceso']=Carbon::now()->format('Y/m/d');
            $request['min_edad']=$vRangoEdad->min_edad;
            $request['max_edad']=$vRangoEdad->max_edad;
            $vRetornoInsercion=$this->create(
                $request
            );
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRetornoInsercion;
    }
    public function fnCustomUpdate($pParametros,$pConstante,$pReemplazo){
        $vTransaccion='';
        try {
            
            DB::beginTransaction();
            $vBusqueda= constant(CustomQuerysRemesa::class."::".$pConstante);
            $vReemplazo=str_replace(':tx_campo',$pReemplazo,$vBusqueda);
            $vTransaccion=DB::statement($vReemplazo,$pParametros);
            DB::commit();
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
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
    
}
