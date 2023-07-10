<?php

namespace App\Http\Controllers\logica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdenesController extends Controller
{
    public function fnIndex(){
        $pCruds=array(
                'Ordenes|MCoreOrdenes|Listado de Órdenes|fnOrdenes|12|/sgd.configurar.ordenes',
            );
        $vMenu=521;
        $vSubmenu=522;
        $vScripts=array('buslogic/objetos.js','buslogic/core.js','buslogic/listar.js','buslogic/agregar.js','buslogic/actualizar.js');
		return view('crud-template.crud-view',
            compact('pCruds','vMenu','vSubmenu','vScripts'));
    }
}
