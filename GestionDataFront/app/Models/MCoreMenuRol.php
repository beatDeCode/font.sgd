<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Validator;

class MCoreMenuRol extends Model{
	protected $table="coremenurol";
    public $timestamps = false;
    public $incrementing=false;
	protected $fillable=
	["cd_menu_rol",

	"cd_menu",
	"cd_rol"];
	static function fnValidaciones(){
		return $validations=
		["cd_menu_rol"=> "required",
	 	"cd_menu"=> "required",
	  	"cd_rol"=> "required",
	  	];
	}
	static function fnMensajes(){
        return $validations=[
        "cd_menu_rol.required"=> "El Campo es requerido.",
        "cd_menu.required"=> "El Campo es requerido.",
        "cd_rol.required"=> "El Campo es requerido.",
        ];
    }

    public function fnListar(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                "SELECT 
                	cd_menu_rol,
                    (select tx_rol from coreroles where cd_rol=a1.cd_rol)tx_rol,
                    (select tx_menu from coremenu where cd_menu=a1.cd_menu)tx_menu,
                    cd_rol,
                    cd_menu
                FROM coremenurol a1
                where cd_menu>=500");
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }
    public function fnListarPorId($pId){
        $vTransaccion='';
        try {
            $vBusqueda=
            'SELECT 
               cd_menu_rol,
               cd_menu,
               cd_rol
            FROM coremenurol usua
            where cd_menu_rol=?';
            $vTransaccion=DB::select($vBusqueda,[$pId]);
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }
    static function fnRetornarSecuencia(){
        $vSecuencia=DB::select('select coremenurol_seq.nextval secuencia from dual');
        return $vSecuencia[0]->secuencia;
    }
    public function fnAgregar($request){
        $vRetornoOperacion='';
        try {
            $request->request->add(['cd_menu_rol'=>$this->fnRetornarSecuencia()]);
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
                $this->where(
                    array('cd_menu_rol'=>$request->post('cd_menu_rol'))
                )->update($request->except(['_token_md','nombreController_cd']));
                $vRetornoOperacion=1;
            }
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }


}
