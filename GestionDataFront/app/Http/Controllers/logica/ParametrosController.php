<?php

namespace App\Http\Controllers\logica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParametrosController extends Controller{
    public function fnIndex(){
        $pCruds=array(
                'Gestión de Parámetros del Sistema|MCoreParametros|Creación de Parámetros del Sistema|fnParametros|12|/sgd.configurar.parametros',);
        $vMenu=504;
        $vSubmenu=506;
        $vScripts=array('buslogic/objetos.js','buslogic/core.js','buslogic/listar.js','buslogic/agregar.js','buslogic/actualizar.js');
		return view('crud-template.crud-view',
            compact('pCruds','vMenu','vSubmenu','vScripts'));
    }
}
