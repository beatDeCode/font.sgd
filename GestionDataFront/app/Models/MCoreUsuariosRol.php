<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Validator;
use Carbon\Carbon;

class MCoreUsuariosRol extends Model{
    protected $table="coreusuariosrol";
    protected $attributes  =['cd_app'=>1];
    protected $primaryKey='cd_rol_usuario';
    public $timestamps = false;
    public $incrementing=false;
    protected $fillable=["cd_usuario","cd_rol","cd_rol_usuario","cd_app"];

    static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select coreusuariosrol_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }
    public function fnAgregar($request){
        $vRetornoOperacion='';
        try {
            $request['cd_rol_usuario']=$this->fnRetornarSecuencia();
            $vRetornoInsercion=$this->create(
                $request
            );
            $vRetornoOperacion='1';
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
    function fnActualizar($pCdUsuario,$pCdRol){
        $vRetornoOperacion=0;
        try {
            $vRetornoInsercion=$this->where(
                array('cd_usuario'=>$pCdUsuario)
            )->update(array('cd_rol'=>$pCdRol));
            $vRetornoOperacion=1;  
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
}
