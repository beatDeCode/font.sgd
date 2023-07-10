<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use CustomQuerysRemesa;

class MCoreProcesoCampania extends Model{
     protected $table="coreprocesocampania";
    protected $primaryKey='cd_proceso_campania';
    protected $attributes  =['in_solicitud_seguros'=>0,'in_emision'=>0,'in_cuadro_poliza'=>0];
    public $timestamps = false;
    public $incrementing=false;
    protected $fillable=[
        "cd_proceso_campania",
        "in_solicitud_seguros",
        "cd_campania",
        "in_emision",
        "in_cuadro_poliza",
        "in_emision",
        "nu_consecutivo",
        "fe_proceso",
    ];
    static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select coreprocesocampania_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }

    public function fnAgregar($pCdCampania, $pNuConsecutivo){
    	$request=array();
        $vRetornoInsercion=array();
        try {

            $vSecuenciaProcesoTecnico=$this->fnRetornarSecuencia();
            $request['cd_proceso_campania']=$vSecuenciaProcesoTecnico;
            $request['nu_consecutivo']=$pNuConsecutivo;
            $request['cd_campania']=$pCdCampania;
            $request['fe_proceso']=Carbon::now()->format('Y/m/d');
            
            $vRetornoInsercion=$this->create(
                $request
            );
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRetornoInsercion;
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
