<?php

namespace App\Http\Controllers\logica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuariosController extends Controller{
    public function fnIndex(){
        $pCruds=array(
                'Gestión de Usuarios|MCoreUsuarios|Creación de Usuarios|fnUsuarios|12|/sgd.configurar.usuarios',
                'Roles|MCoreRoles|Creación de Roles|fnRoles|6|/sgd.configurar.usuarios',
                'Menus Por Rol|MCoreMenuRol|Creación de Menus Por Rol|fnMenus|6|/sgd.configurar.usuarios'

            );
        $vMenu=504;
        $vSubmenu=506;
        $vScripts=array('buslogic/objetos.js','buslogic/core.js','buslogic/listar.js','buslogic/agregar.js','buslogic/actualizar.js');
		return view('crud-template.crud-view',
            compact('pCruds','vMenu','vSubmenu','vScripts'));
    }
}
