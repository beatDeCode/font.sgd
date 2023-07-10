<?php

namespace App\Http\Controllers\logica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VariablesAnexoController extends Controller{
    public function fnIndex(){
        $pCruds=array(
            'Mostrar Formulario Técnico por Variables |MCoreVariablesAnexo|Creación de Expresiones|fnVariablesAnexo|6|/sgd.configurar.variables-anexo',
         );
        $vMenu=504;
        $vSubmenu=506;
        $vScripts=array('buslogic/objetos.js','buslogic/core.js','buslogic/listar.js','buslogic/agregar.js','buslogic/actualizar.js');
		return view('crud-template.crud-view',
            compact('pCruds','vMenu','vSubmenu','vScripts'));
    }
}
