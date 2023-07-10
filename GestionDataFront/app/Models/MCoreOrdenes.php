<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Carbon\Carbon;

class MCoreOrdenes extends Model{
	protected $table="coreordenes";
    protected $attributes  =['st_orden'=>1];
    protected $primaryKey='cd_orden';
    public $timestamps = false;
	protected $fillable=[
			"tx_nombre_archivo",
			"tx_funcion_programa",
			"tx_directorio_descarga",
			"st_orden",
			"parametro5",
			"parametro4",
			"parametro3",
			"parametro2",
			"parametro1",
			"fe_orden_ini",
			"fe_orden_fin",
			"cd_usuario",
			"cd_programa",
			"cd_cola",
			"cd_orden"];

	static function fnRetornarSecuencia(){
    	$vSecuencia=DB::select('select coreordenes_seq.nextval secuencia from dual');
    	return $vSecuencia[0]->secuencia;
    }
	public function fnAgregar($request){
        $vRetornoOperacion='';
        try {
			$request['cd_orden']=$this->fnRetornarSecuencia();
				
            $vRetornoInsercion=$this->create(
                $request
            );
            $vRetornoOperacion='1';
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
 
}
