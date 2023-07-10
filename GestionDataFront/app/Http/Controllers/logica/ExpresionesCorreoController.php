<?php

namespace App\Http\Controllers\logica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpresionesCorreoController extends Controller{
    public function fnIndex(){
        $pCruds=array(
                'Expresiones de Correo|MCoreExpresionesCorreo|Creación de Expresiones|fnExpresionesCorreo|12|/sgd.configurar.expresionescorreo',);
        $vMenu=504;
        $vSubmenu=506;
        $vScripts=array('buslogic/objetos.js','buslogic/core.js','buslogic/listar.js','buslogic/agregar.js','buslogic/actualizar.js');
		return view('crud-template.crud-view',
            compact('pCruds','vMenu','vSubmenu','vScripts'));
    }
}


