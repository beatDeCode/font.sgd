function fnUsuarios(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('C&oacute;digo Usuario')
    vNombresCabeceraDt.push('Nombre del Usuario')
    vNombresCabeceraDt.push('Correo del Usuario')
    vNombresCabeceraDt.push('Rol')
    vNombresCabeceraDt.push('Estatus');
    vNombresCabeceraDt.push('Acciones');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('cd_usuario');
    vIndicesCuerpoDt.push('nm_usuario');
    vIndicesCuerpoDt.push('tx_correo');
    vIndicesCuerpoDt.push('tx_rol');
    vIndicesCuerpoDt.push('st_usuario');
    var vIdDataTable='datatable-usuarios';
    var vIndiceClave='cd_usuario';
    var vInputsHidden=[];
    vInputsHidden.push('cd_rol');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    vRetorno.push(vIdDataTable);
    vRetorno.push(vIndiceClave);
    vRetorno.push(vInputsHidden);
    return vRetorno;
}
function fnUsuariosForms(){
    var vInputs=[];
    vInputs.push('cd_usuario|input|text|C&oacute;digo de Usuario|6');
    vInputs.push('nm_usuario|input|text|Nombre de Usuario|6');
    vInputs.push('tx_correo|input|email|Correo|6');
    vInputs.push('st_usuario|select|estatus|Estatus del Usuario|6');
    vInputs.push('cd_rol|select|link:MCoreRoles|Rol|6');
    return vInputs;
}
function fnUsuariosFormsUpdate(){
    var vInputs=[];
    vInputs.push('cd_usuario|input|text|C&oacute;digo de Usuario|6');
    vInputs.push('nm_usuario|input|text|Nombre de Usuario|6');
    vInputs.push('tx_correo|input|email|Correo|6');
    vInputs.push('st_usuario|select|estatus|Estatus del Usuario|6');
    vInputs.push('cd_rol|select|link:MCoreRoles|Rol|6');
    return vInputs;
}

function fnRoles(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('C&oacute;digo Rol')
    vNombresCabeceraDt.push('Nombre del Rol')
    vNombresCabeceraDt.push('Estatus');
    vNombresCabeceraDt.push('Acciones');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('cd_rol');
    vIndicesCuerpoDt.push('tx_rol');
    vIndicesCuerpoDt.push('st_rol');
    var vIdDataTable='datatable-roles';
    var vIndiceClave='cd_rol';
    var vInputsHidden=[];
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    vRetorno.push(vIdDataTable);
    vRetorno.push(vIndiceClave);
    return vRetorno;
}
function fnRolesForms(){
    var vInputs=[];
    vInputs.push('tx_rol|input|text|Nombre del rol|6');
    vInputs.push('st_rol|select|estatus|Estatus del Usuario|6');
    return vInputs;
}
function fnRolesFormsUpdate(){
    var vInputs=[];
    vInputs.push('cd_rol|input|hidden|Nombre del rol|6');
    vInputs.push('tx_rol|input|text|Nombre del rol|6');
    vInputs.push('st_rol|select|estatus|Estatus del Usuario|6');
    return vInputs;
}

function fnRemesaCarga(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('C&oacute;digo Remesa');
    vNombresCabeceraDt.push('Consecutivo');
    vNombresCabeceraDt.push('Fecha');
    vNombresCabeceraDt.push('Nombre de la remesa');
    vNombresCabeceraDt.push('Usuario');
    vNombresCabeceraDt.push('Producto');
    vNombresCabeceraDt.push('Aliado');
    vNombresCabeceraDt.push('Registros Estimados');
    vNombresCabeceraDt.push('Progreso de la remesa');
    vNombresCabeceraDt.push('Estatus');
    vNombresCabeceraDt.push('Log');
    var vIdDataTable='datatable-remesa-carga';
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIdDataTable);
    return vRetorno;
}

function fnParametros(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('C&oacute;digo de Tabla')
    vNombresCabeceraDt.push('Valor del Par&aacutemetro')
    vNombresCabeceraDt.push('Estatus');
    vNombresCabeceraDt.push('Acciones');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('cd_tabla');
    vIndicesCuerpoDt.push('cd_valor');
    vIndicesCuerpoDt.push('st_parametro');
    var vIdDataTable='datatable-parametros';
    var vIndiceClave='cd_parametro';
    var vInputsHidden=[];
    vInputsHidden.push('cd_parametro');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    vRetorno.push(vIdDataTable);
    vRetorno.push(vIndiceClave);
    vRetorno.push(vInputsHidden);
    return vRetorno;
}
function fnParametrosForms(){
    var vInputs=[];
    vInputs.push('cd_tabla|input|text|C&oacute;digo de la tabla|6');
    vInputs.push('cd_valor|input|text|Valor del par&aacute;rametro|6');
    vInputs.push('st_parametro|select|estatus|Estatus del par&aacute;rametro|6');
    return vInputs;
}
function fnParametrosFormsUpdate(){
    var vInputs=[];
    vInputs.push('cd_parametro|input|hidden|C&oacute;digo de la tabla|6');
    vInputs.push('cd_tabla|input|text|C&oacute;digo de la tabla|6');
    vInputs.push('cd_valor|input|text|Valor del par&aacute;rametro|6');
    vInputs.push('st_parametro|select|estatus|Estatus del Usuario|6');
    return vInputs;
}

function fnExpresionesCorreo(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('C&oacute;digo expresi&oacute;n')
    vNombresCabeceraDt.push('Expresi&oacute;n a Reemplazar')
    vNombresCabeceraDt.push('Reemplazo')
    vNombresCabeceraDt.push('Acciones');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('cd_expresion');
    vIndicesCuerpoDt.push('tx_expresion');
    vIndicesCuerpoDt.push('tx_modificacion');
    var vIdDataTable='datatable-expresionescorreo';
    var vIndiceClave='cd_expresion';
    var vInputsHidden=[];
    vInputsHidden.push('cd_expresion');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    vRetorno.push(vIdDataTable);
    vRetorno.push(vIndiceClave);
    vRetorno.push(vInputsHidden);
    return vRetorno;
}
function fnExpresionesCorreoForms(){
    var vInputs=[];
    vInputs.push('tx_expresion|input|text|Expresi&oacute;n a Reemplazar|6');
    vInputs.push('tx_modificacion|input|text|Reemplazo|6');
    return vInputs;
}
function fnExpresionesCorreoFormsUpdate(){
    var vInputs=[];
    vInputs.push('cd_expresion|input|hidden|Expresi&oacute;n a Reemplazar|6');
    vInputs.push('tx_expresion|input|text|Expresi&oacute;n a Reemplazar|6');
    vInputs.push('tx_modificacion|input|text|Reemplazo|6');
    return vInputs;
}
function fnMenus(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('Rol')
    vNombresCabeceraDt.push('Men&uacute;')
    vNombresCabeceraDt.push('Acciones');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('tx_rol');
    vIndicesCuerpoDt.push('tx_menu');
    var vIdDataTable='datatable-menurol';
    var vIndiceClave='cd_menu_rol';
    var vInputsHidden=[];
    vInputsHidden.push('cd_rol');
    vInputsHidden.push('cd_menu');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    vRetorno.push(vIdDataTable);
    vRetorno.push(vIndiceClave);
    vRetorno.push(vInputsHidden);
    return vRetorno;
}
function fnMenusForms(){
    var vInputs=[];
    vInputs.push('cd_rol|select|link:MCoreRoles|Rol|6');
    vInputs.push('cd_menu|select|link:MCoreMenu|Menu|6');
    return vInputs;
}
function fnMenusFormsUpdate(){
    var vInputs=[];
    vInputs.push('cd_menu_rol|input|hidden|Expresi&oacute;n a Reemplazar|6');
    vInputs.push('cd_menu|select|link:MCoreMenu|Menu|6');
    vInputs.push('cd_rol|select|link:MCoreRoles|Rol|6');
    return vInputs;
}

function fnVariablesAnexo(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('C&oacute;digo Variable Anexo')
    vNombresCabeceraDt.push('Nombre de la Variable')
    vNombresCabeceraDt.push('¿Aplica para Formulario Técnico?');
    vNombresCabeceraDt.push('Acciones');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('cd_variable_anexo');
    vIndicesCuerpoDt.push('tx_variable');
    vIndicesCuerpoDt.push('in_aplica_formulario');
    var vIdDataTable='datatable-variables-anexo';
    var vIndiceClave='cd_variable_anexo';
    var vInputsHidden=[];
    vInputsHidden.push('cd_variable');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    vRetorno.push(vIdDataTable);
    vRetorno.push(vIndiceClave);
    vRetorno.push(vInputsHidden);
    return vRetorno;
}
function fnVariablesAnexoForms(){
    var vInputs=[];
    vInputs.push('cd_variable|select|link:MCoreVariablesCallCenter|Variable|12');
    vInputs.push('in_aplica_formulario|select|confirmacion|Aplica Formulario|12');
    return vInputs;
}
function fnVariablesAnexoFormsUpdate(){
    var vInputs=[];
    vInputs.push('cd_variable_anexo|input|hidden|C&oacute;digo de la tabla|6');
    vInputs.push('cd_variable|select|link:MCoreVariablesCallCenter|Variable|12');
    vInputs.push('in_aplica_formulario|select|confirmacion|Aplica Formulario|12');
    return vInputs;
}
function fnOrdenes(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('C&oacute;digo Orden')
    vNombresCabeceraDt.push('Proceso')
    vNombresCabeceraDt.push('Usuario')
    vNombresCabeceraDt.push('Fecha');
    vNombresCabeceraDt.push('Estatus')
    
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('cd_usuario');
    vIndicesCuerpoDt.push('cd_programa');
    vIndicesCuerpoDt.push('cd_usuario');
    vIndicesCuerpoDt.push('fe_proceso');
    vIndicesCuerpoDt.push('st_proceso');
    var vIdDataTable='datatable-ordenes';
    var vIndiceClave='cd_orden';
    var vInputsHidden=[];
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    vRetorno.push(vIdDataTable);
    vRetorno.push(vIndiceClave);
    vRetorno.push(vInputsHidden);
    return vRetorno;
}