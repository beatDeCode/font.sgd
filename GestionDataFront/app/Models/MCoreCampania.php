<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
use DB;
use Carbon\Carbon;
use CustomQuerysRemesa;


class MCoreCampania extends Model{
    protected $table="corecampania";
    protected $attributes  =['st_campania'=>1];
    protected $primaryKey='cd_campania';
    public $timestamps = false;
    protected $fillable=[
    "tx_campania",
    "st_campania",
    "fe_fin",
    "fe_inicio",
    "cd_proceso_tecnico",
    "cd_campania","nu_consecutivo"];
    static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select corecampania_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }
    
    public function fnAgregar($request){
        $vRetornoArregloOrden=array();
        try {
            $vCdUsuario=Session::get('user')['cd_usuario'];
            $vSecuenciaCampania=$this->fnRetornarSecuencia();
            $request['nu_consecutivo']=1;
            $request['cd_usuario']=$vCdUsuario;
            $request['cd_campania']=$vSecuenciaCampania;
            $request['tx_campania']='CAMPANIA-COD-#'.$vSecuenciaCampania.
                    '-PROCESO_TEC-#'.$request['cd_proceso_tecnico'].
                    '-FE_INI#'.Carbon::now()->format('Y/m/d');
            $request['fe_inicio']=Carbon::now()->format('Y/m/d');
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
    public function fnBuscarNombreDeVariable($pCdVaribale){
        $vSecuencia=DB::select('select tx_variable from corevariablescallcenter where cd_variable=:cd_variable',array('cd_variable'=>$pCdVaribale));
        return $vSecuencia[0]->tx_variable;
    }
}
