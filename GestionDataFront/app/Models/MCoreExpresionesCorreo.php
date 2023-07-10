<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Validator;

class MCoreExpresionesCorreo extends Model{
    protected $table="coreexpresionescorreo";
    protected $primaryKey='cd_expresion';
    public $timestamps = false;
    protected $fillable=["tx_modificacion","tx_expresion","cd_expresion"];
    static function fnValidaciones(){return $validations=[
        "tx_modificacion"=> "required",
        "tx_expresion"=> "required|unique:CoreExpresionesCorreo,tx_expresion"
     ];}

    static function fnValidacionesUpd(){return $validations=[
        "tx_modificacion"=> "required",
        "tx_expresion"=> "required"
     ];}

    static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select coreexpresionescorreo_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }

    static function fnMensajes(){
        return $validations=[
        "tx_modificacion.required"=> "El Campo es requerido",
        "tx_expresion.required"=> "El Campo es requerido",
        "tx_expresion.unique"=> "El valor introducido ya existe"
        ];
    }
    static function fnMensajesUpd(){
        return $validations=[
        "tx_modificacion.required"=> "El Campo es requerido",
        "tx_expresion.required"=> "El Campo es requerido",
        ];
    }
    public function fnListar(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                'SELECT 
                    cd_expresion,
                    tx_expresion,
                    tx_modificacion,
                    1 st_eliminar
                    FROM coreexpresionescorreo rous ');
            $vTransaccion=array_map(function($valor){
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
            $request->request->add(['cd_expresion'=>$this->fnRetornarSecuencia()]);
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
                cd_expresion,
                tx_expresion,
                tx_modificacion
            FROM coreexpresionescorreo core
            where cd_expresion=?';
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
                $this->fnValidacionesUpd(),
                $this->fnMensajesUpd()
            );
            if($vValidarFormulario->fails()){
               $vRetornoOperacion= $vValidarFormulario->errors();
            }else{
                $vRetornoInsercion=$this->where(
                    array('cd_expresion'=>$request->post('cd_expresion'))
                )->update($request->except(['_token_md','nombreController_cd',"cd_expresion"]));
                $vRetornoOperacion=1;
            }
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
    public function fnEliminar($pId){
		try {
			$this->where(array('cd_expresion'=>$pId))
			->delete();
		} catch (Exception $e) {
			$e->getMessage();
		}
	}

}
