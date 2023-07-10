<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MCoreMenu extends Model{
	protected $table="coremenu";
    protected $primaryKey='cd_menu';
    public $timestamps = false;
    public $incrementing=false;
    protected $fillable=
	    ["cd_app",
	    "cd_orden",
	    "tp_menu",
	    "st_menu",
	    "cd_menu_padre",
	    "tx_icono",
	    "tx_enlace",
	    "tx_menu","cd_menu"];
	static function fnValidaciones(){
		return $validations=["cd_app"=> "required",
		 "cd_orden"=> "required",
		 "tp_menu"=> "required",
		 "st_menu"=> "required",
		 "cd_menu_padre"=> "required",
		 "tx_icono"=> "required",
		 "tx_enlace"=> "required",
		 "tx_menu"=> "required",
		 "cd_menu"=> "required",
		 ];}
		 
	public function fnValoresParaSelect(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                "select cd_menu value, tx_menu text,'cd_menu' name,'Menús' title, '6' col
                from coremenu 
                where tp_menu=3
                order by cd_menu desc");
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vTransaccion;
    }
    public function fnListarPorId($pId){
        $vTransaccion='';
        try {
            $vBusqueda=
            'SELECT 
                cd_menu,
                tx_menu
            FROM coremenu usua
            where cd_menu=?';
            $vTransaccion=DB::select($vBusqueda,[$pId]);
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }



}
