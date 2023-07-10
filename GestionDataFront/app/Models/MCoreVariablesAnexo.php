<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Validator;


class MCoreVariablesAnexo extends Model{

    protected $table="corevariablesanexo";
    protected $primaryKey='cd_variable_anexo';
    public $timestamps = false;
    protected $fillable=["cd_variable","in_aplica_formulario","cd_variable_anexo"];
    static function fnValidaciones(){return $validations=[
        "in_aplica_formulario"=> "required",
        "cd_variable"=> "required|unique:corevariablesanexo,cd_variable"
     ];}

    static function fnValidacionesUpd(){return $validations=[
        "cd_variable"=> "required",
        "in_aplica_formulario"=> "required"
     ];}

    static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select corevariablesanexo_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }

    static function fnMensajes(){
        return $validations=[
        "in_aplica_formulario.required"=> "El Campo es requerido",
        "cd_variable.required"=> "El Campo es requerido",
        "cd_variable.unique"=> "El valor introducido ya existe"
        ];
    }
    static function fnMensajesUpd(){
        return $validations=[
        "in_aplica_formulario.required"=> "El Campo es requerido",
        "cd_variable.required"=> "El Campo es requerido",
        ];
    }
    public function fnListar(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                "SELECT 
                    cd_variable_anexo,
                    (select tx_variable from corevariablescallcenter where cd_variable=vaax.cd_variable) tx_variable,
                    case when in_aplica_formulario=0 then 'No' else 'Si' end in_aplica_formulario,
                    cd_variable
                    FROM corevariablesanexo vaax 
                    where (select cd_relacion from corevariablescallcenter where cd_variable=vaax.cd_variable) is not null ");
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
            $request->request->add(['cd_variable_anexo'=>$this->fnRetornarSecuencia()]);
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
                cd_variable_anexo,
                (select tx_variable from corevariablescallcenter where cd_variable=vaax.cd_variable) tx_variable,
                cd_variable,
                in_aplica_formulario
             FROM corevariablesanexo vaax
            where cd_variable_anexo=?';
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
                    array('cd_variable_anexo'=>$request->post('cd_variable_anexo'))
                )->update($request->except(['_token_md','nombreController_cd',"cd_variable_anexo"]));
                $vRetornoOperacion=1;
            }
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
    public function fnEliminar($pId){
		try {
			$this->where(array('cd_variable_anexo'=>$pId))
			->delete();
		} catch (Exception $e) {
			$e->getMessage();
		}
	}
}
