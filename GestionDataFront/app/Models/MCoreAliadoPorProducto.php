<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class MCoreAliadoPorProducto extends Model{
    
	public function fnProductosPermitidos(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                'SELECT cd_producto value, initcap(de_producto) text 
                FROM producto 
                WHERE cd_producto IN (
    				SELECT cd_producto FROM COREALIADOPORPRODUCTO
    			)');
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vTransaccion;
    }
    public function fnAliadosPermitidos(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                'SELECT va_dato1 value, initcap(de_dato) text 
                FROM tablainformacion 
                where cd_tabla=410094
                and va_dato1 in (
    				SELECT cd_aliado FROM COREALIADOPORPRODUCTO
    			)');
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
        } catch (Exception $th) {
            $th->getMessage();
        }
        return $vTransaccion;
    }

}
