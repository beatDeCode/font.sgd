<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Validator;

class MCoreParametros extends Model
{
    protected $table="coreparametros";
    public $incrementing=false;
    protected $primaryKey='cd_parametro';
    public $timestamps = false;
    protected $attributes  =['st_parametro'=>1];
    protected $fillable=["cd_valor","st_parametro","cd_tabla","cd_parametro"]; 
    
    
    static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select COREPARAMETROS_SEQ.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }
    static function fnValidaciones(){return $validations=[
        "cd_valor"=> "required",
        "cd_tabla"=> "required",
        "cd_parametro"=> "required",
     ];}

     static function fnMensajes(){
        return $validations=[
        "cd_valor.required"=> "El Campo es requerido",
        "cd_tabla.required"=> "El Campo es requerido",
        "cd_parametro.required"=> "El Campo es requerido",
        ];
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
                    FROM coreparametros rous
                    order by cd_tabla asc ');
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
    public function fnAgregar($request){
        $vRetornoOperacion='';
        try {
            $request->request->add(['cd_parametro'=>$this->fnRetornarSecuencia()]);
            $vValidarFormulario = Validator::make(
                $request->all(),
                $this->fnValidaciones(),
                $this->fnMensajes()
            );
            if($vValidarFormulario->fails()){
                $vRetornoOperacion= $vValidarFormulario->errors();
            }else{
                $vRetornoInsercion=$this->create(
                    $request->except(['_token_md','nombreController_cd'])
                );
                $vRetornoOperacion='1';
            }
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
    public function fnListarPorId($pId){
        $vTransaccion='';
        try {
            $vBusqueda=
            'SELECT 
                cd_parametro,
                cd_tabla,
                st_parametro,
                cd_valor
            FROM coreparametros core
            where cd_parametro=?
            order by cd_tabla asc';
            $vTransaccion=DB::select($vBusqueda,[$pId]);
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }
    function fnActualizar($request){
        $vRetornoOperacion=0;
        try {

            $vValidarFormulario = Validator::make(
                $request->all(),
                $this->fnValidaciones(),
                $this->fnMensajes()
            );
            if($vValidarFormulario->fails()){
               $vRetornoOperacion= $vValidarFormulario->errors();
            }else{
                $vRetornoInsercion=$this->where(
                    array('cd_parametro'=>$request->post('cd_parametro'))
                )->update($request->except(['_token_md','nombreController_cd',"cd_parametro"]));
                $vRetornoOperacion=1;
            }
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
    public function fnEliminar($pId){
		try {
			$this->where(array('cd_parametro'=>$pId))
			->delete();
		} catch (Exception $e) {
			$e->getMessage();
		}
	}
    public function fnActualizarParametro($request){
        $vRetornoOperacion=0;
        try {
            $vRetornoInsercion=$this->where(
                array('cd_parametro'=>$request['cd_parametro'])
            )->update($request);
            $vRetornoOperacion=1;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }

    public function fnAgregarParametro($request){
        $vRetornoOperacion=0;
        try {
            $request['cd_parametro']=$this->fnRetornarSecuencia();
            $request['cd_tabla']='CC_VARIABLE_NC';
            $vRetornoInsercion=$this->create(
                $request
            );
            $vRetornoOperacion=1;
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }

}
