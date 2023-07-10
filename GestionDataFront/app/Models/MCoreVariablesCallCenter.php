<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CustomQuerysRemesa;
use DB;

class MCoreVariablesCallCenter extends Model{
    protected $table="corevariablescallcenter";
    protected $primaryKey='cd_variable';
    public $timestamps = false;
    public $incrementing=false;
	protected $fillable=[
		"in_decision_final",
		"in_dependencia",
		"cd_relacion",
		"nu_nivel",
		"st_variable",
		"tx_variable",
		"cd_padre",
		"cd_variable"
	];
	static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select corevariablescallcenter_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }
    public function fnListar(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                'SELECT 
                    initcap(cd_tabla) cd_tabla,
                    cd_parametro,
                    cd_valor,
                    st_parametro ,
                    1 st_eliminar 
                    FROM coreparametros rous ');
            $vTransaccion=array_map(function($valor){
                if($valor->st_parametro==1){ 
                    $valor->st_parametro='<span class="badge me-1 bg-success">Activo</span>';
                }else{
                    $valor->st_parametro='<span class="badge me-1 bg-danger">Inactivo</span>';
                }
                return (array)$valor;
            }, $vTransaccion);
            
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
    public function fnEliminar($pCdVariable){
        $vRetornoOperacion='';
        try {
            $vBusquedaUpdate=$this::where(
                'cd_variable',$pCdVariable
            )->delete();
            $vRetornoOperacion='1';
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
    public function fnModificar($request,$pCondicion){
        $vRetornoOperacion='';
        try {
            if($pCondicion==1){
                $request['cd_variable']=$this->fnRetornarSecuencia();
                $this->create(
                    $request
                );
            }else{
                $vBusquedaUpdate=$this->find(
                    $request['cd_variable']
                );
                $vBusquedaUpdate->tx_variable=$request['tx_variable'];
                $vBusquedaUpdate->in_dependencia=$request['in_dependencia'];
                $vBusquedaUpdate->cd_accion=$request['cd_accion'];
                $vBusquedaUpdate->cd_relacion=$request['cd_relacion'];
                $vBusquedaUpdate->nu_nivel=$request['nu_nivel'];
                $vBusquedaUpdate->in_decision_final=$request['in_decision_final'];
                $vBusquedaUpdate->st_variable=1;
                $vBusquedaUpdate->save();
            }
           
            $vRetornoOperacion='1';
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }

    public function fnValoresParaSelect(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                "select cd_variable value, tx_variable text,'cd_variable' name,'Variables' title, '6' col
                from corevariablescallcenter 
                where nu_nivel=2");
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vTransaccion;
    }
}
