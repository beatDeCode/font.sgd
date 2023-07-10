<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCoreGestionEmision extends Model
{
    protected $table="coregestionemision";
    protected $primaryKey='cd_gestion_remesa';
    public $timestamps = false;
    public $incrementing=false;
	protected $fillable=["cd_remesa","cd_gestion_remesa","tx_mensaje","nu_documento"];
	public function fnEliminarRegistros($pCdGestionRemesa){
		try {
			$this->where('cd_gestion_remesa',$pCdGestionRemesa)
			->delete();
		} catch (Exception $e) {
			$e->getMessage();
		}
	}
}
