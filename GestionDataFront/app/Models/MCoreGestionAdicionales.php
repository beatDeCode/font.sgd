<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MCoreGestionAdicionales extends Model{
    protected $table="coregestionadicionales";
    protected $primaryKey='cd_gestion_adicional';
    public $timestamps = false;
    public $incrementing=false;
	protected $fillable=[
        "cd_gestion_adicional",
		"cd_gestion_remesa",
		"nu_area",
		"nu_telefono",
        "tp_documento",
        "nu_documento",
		"fe_nacimiento",
		"cd_parentesco"];
    
    static function fnRetornarSecuencia(){
        $vSecuencia=DB::select('select coregestionadicional_seq.nextval secuencia from dual');
        return $vSecuencia[0]->secuencia;
    }
    public function fnAgregar($request){
        $vRetornoOperacion=0;
        try {
            $request['cd_gestion_adicional']=$this->fnRetornarSecuencia();
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
