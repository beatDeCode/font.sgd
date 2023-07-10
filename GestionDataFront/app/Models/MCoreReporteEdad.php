<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MCoreReporteEdad extends Model
{
    protected $table="corereporteedad";
    protected $primaryKey='cd_rango_edad';
    public $timestamps = false;
    public $incrementing=false;
    protected $fillable=["cd_rango_edad","cd_edad","min_edad","max_edad","cd_aliado","cd_rango_edad"];

    static function fnValidaciones(){
        return $validations=[
        "cd_edad"=>"required",
        "min_edad"=>"required",
        "max_edad"=>"required",
        "cd_aliado"=>"required",
        "cd_rango_edad"=>"required"
     ];}

    static function fnMensajes(){
        return $validations=[
        "cd_edad.required"=>"El campo está vacío.",
        "min_edad.required"=>"El campo está vacío.",
        "max_edad.required"=>"El campo está vacío.",
        "cd_aliado.required"=>"El campo está vacío.",
        "cd_rango_edad.required"=>"El campo está vacío."
        ];
    }
    static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select corereporteedad_seq.nextval secuencia from dual');
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
    public function fnListarPorAliado($pCdAliado){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                'SELECT 
                    cd_aliado,
                    cd_edad,
                    cd_rango_edad,
                    min_edad,
                    max_edad
                    FROM corereporteedad rous
                    where cd_aliado=:cd_aliado
                    order by min_edad asc',['cd_aliado'=>$pCdAliado]);
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }
    public function fnBuscarNombreAliado($pCdAliado){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                'SELECT 
                    de_dato
                    FROM tablainformacion rous
                    where cd_tabla=410094 
                    and va_dato1=:cd_aliado
                    ',['cd_aliado'=>$pCdAliado]);
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
    public function fnModificar($request,$pCondicion){
        $vRetornoOperacion='';
        try {
            if($pCondicion==1){
                $request['cd_rango_edad']=$this->fnRetornarSecuencia();
                $request['cd_edad']= 'E'.$request['max_edad'];
                $this->create(
                    $request
                );
            }else{
                $vBusquedaUpdate=$this->find(
                    $request['cd_rango_edad']
                );
                $vBusquedaUpdate->min_edad=$request['min_edad'];
                $vBusquedaUpdate->max_edad=$request['max_edad'];
                $vBusquedaUpdate->save();
            }
           
            $vRetornoOperacion='1';
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
    public function fnEliminar($pCdRangoEdad){
        $vRetornoOperacion='';
        try {
            
            $vBusquedaUpdate=$this::where(
                'cd_rango_edad',$pCdRangoEdad
            )->delete();
            $vRetornoOperacion='1';
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
}
