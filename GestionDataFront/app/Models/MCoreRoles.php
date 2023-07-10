<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Validator;
use Carbon\Carbon;

class MCoreRoles extends Model{
    protected $table="coreroles";
    protected $primaryKey='cd_rol';
    public $timestamps = false;
    public $incrementing=false;
    protected $fillable=["cd_rol","tx_rol","st_rol"];

    static function fnValidaciones(){
        return $validations=["tx_rol"=> "required|unique:coreroles,tx_rol",
         "st_rol"=> "required",
     ];}

    static function fnMensajes(){
        return $validations=[
        "st_rol.required"=> "El Campo es requerido",
        "tx_rol.required"=> "El Campo es requerido",
        "tx_rol.unique"=> "El valor introducido ya existe",
        ];
    }
    static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select coreroles_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }
    public function fnValoresParaSelect(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                "select cd_rol value, tx_rol text,'cd_rol' name,'Roles' title, '6' col
                from coreroles ");
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vTransaccion;
    }
    public function fnListar(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                'SELECT 
                    cd_rol,
                    initcap(tx_rol)tx_rol,
                    st_rol
                    FROM coreroles rous ');
            $vTransaccion=array_map(function($valor){
                if($valor->st_rol==1){ 
                    $valor->st_rol='<span class="badge me-1 bg-success">Activo</span>';
                }else{
                    $valor->st_rol='<span class="badge me-1 bg-danger">Inactivo</span>';
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
            $request->request->add(['cd_rol'=>$this->fnRetornarSecuencia()]);
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
                tx_rol,
                st_rol
            FROM coreroles usua
            where cd_rol=?';
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
                    array('cd_rol'=>$request->post('cd_rol'))
                )->update($request->except(['_token_md','nombreController_cd',"cd_rol"]));

            }
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
}
