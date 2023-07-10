<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

class MCoreGestionCampania extends Model{
    protected $table="coregestioncampania";
    protected $primaryKey='cd_gestion_campania';
    public $timestamps = false;
    public $incrementing=false;
	protected $fillable=[
        "cd_variable0",
		"cd_variable4",
		"cd_variable3",
		"cd_variable2",
        "cd_grupo_familiar",
        "cd_adicionales",
        "cd_suma_asegurada",
		"cd_usuario",
		"fe_registro",
		"cd_variable1",
		"nu_consecutivo",
		"cd_campania",
		"cd_gestion_remesa",
		"cd_gestion_campania","st_gestion_campania"];

	static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select coregestioncampania_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }
    static function fnRetornaDecisionFinalVariable($pCdVariable){
    	$vSecuencia=DB::select('select in_decision_final from corevariablescallcenter where cd_variable=:cd_variable',array('cd_variable'=>$pCdVariable));
    	return $vSecuencia[0]->in_decision_final;
    }
    static function fnRetornaAccionVariable($pCdVariable){
        $vSecuencia=DB::select("select (select cd_valor from coreparametros where cd_tabla like '%1-%'  and cd_valor=core.cd_accion)cd_accion
                                from corevariablescallcenter core
                                where  cd_variable=:cd_variable",array('cd_variable'=>$pCdVariable));
        return $vSecuencia[0]->cd_accion;
    }

    
    static function fnRetornaConsecutivoContactoCliente($vConsecutivoContacto){
        $vSecuencia=DB::select(
                'select count(1)+1 consecutivo from coregestioncampania where cd_gestion_remesa=:cd_gestion_remesa',
                array('cd_gestion_remesa'=>$vConsecutivoContacto));
        return $vSecuencia[0]->consecutivo;
    }
    public function fnAgregar($request){
        $vRetornoArregloOrden=array();
        try {
            $vCdUsuario=Session::get('user')['cd_usuario'];
            $vSecuenciaCampania=$this->fnRetornarSecuencia();
            $request['cd_usuario']=$vCdUsuario;
            $request['nu_consecutivo']=$this->fnRetornaConsecutivoContactoCliente($request['cd_gestion_remesa']);
            $request['cd_gestion_campania']=$vSecuenciaCampania;
            $vRetornoInsercion=$this->create(
                $request
            );
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRetornoInsercion;
    }

}
