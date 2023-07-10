function fnPanelGeneral(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('Variable|Variable de estudio para los registros de la campa&ntilde;a.')
    vNombresCabeceraDt.push('Registros|Cantidad de registros por rango de edad.')
    vNombresCabeceraDt.push('%|Porcentaje de Registros por variables presentes en la campa&ntilde;a.');
    vNombresCabeceraDt.push('Acciones|Botones accionables que sirven para descargar las campa&ntilde;as por variables.');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('tx_variable');
    vIndicesCuerpoDt.push('ca_registros');
    vIndicesCuerpoDt.push('po_registros');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    return vRetorno;
}
function fnPanelPorIntentos(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('Variable|Variable de estudio para los registros de la campa&ntilde;a.')
    vNombresCabeceraDt.push('Sin Contactar| Sin contacto al cliente por llamada telef&oacute;nica.');
    vNombresCabeceraDt.push('Contacto # 1| Intento #1 de contacto al cliente por llamada telef&oacute;nica.');
    vNombresCabeceraDt.push('Contacto # 2| Intento #2 de contacto al cliente por llamada telef&oacute;nica.');
    vNombresCabeceraDt.push('Contacto # 3| Intento #3 de contacto al cliente por llamada telef&oacute;nica.');
    vNombresCabeceraDt.push('Contacto # 4| Intento #3 de contacto al cliente por llamada telef&oacute;nica.');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('tx_variable');
    vIndicesCuerpoDt.push('ca_registros_int_0');
    vIndicesCuerpoDt.push('ca_registros_int_1');
    vIndicesCuerpoDt.push('ca_registros_int_2');
    vIndicesCuerpoDt.push('ca_registros_int_3');
    vIndicesCuerpoDt.push('ca_registros_int_4');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    return vRetorno;
}

function fnTableParaGraficosGenerales(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('Variable')
    vNombresCabeceraDt.push('Registros')
    vNombresCabeceraDt.push('%');
    vRetorno.push(vNombresCabeceraDt);
    return vRetorno;
}

function fnPanelCampaniaEmision(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('C&oacute;digo Proceso|C&oacute;digo representativo del Proceso de la Campa&ntilde ')
    vNombresCabeceraDt.push('C&oacute;digo de la Campa&ntilde|C&oacute;digo de la Campa&ntilde.')
    vNombresCabeceraDt.push('# Contacto|Consecutivo del contacto.')
    vNombresCabeceraDt.push('Registros| Cantidad de registros totales de los procesos t&eacute;cnicos.');
    vNombresCabeceraDt.push('Fecha Proceso|Fecha inicial del Proceso Campa&ntilde');
    vNombresCabeceraDt.push('Fases 1|Comprende la ejecucci&oacute;n de (Solicitud de Seguros o Campa&ntilde;a) dependiendo del porcentaje comercial, si este es menor a 100 % de descuento inicia el proceso de Campa&ntilde;a sino Solicitud de Seguros.');
    vNombresCabeceraDt.push('Fases 2|Comprende la ejecucci&oacute;n de (Emisi&oacute;n Masiva o Solicitud de Seguros) dependiendo del porcentaje comercial, si este es menor a 100 % de descuento se dispondr&aacute; del proceso de Solicitud de Seguros sino de la Emisi&oacute;n Masiva.');
    vNombresCabeceraDt.push('Fases 3|Comprende la ejecucci&oacute;n de (Emisi&oacute;n Masiva o Env&iacute;o Cuadro P&oacute;liza) dependiendo del porcentaje comercial, si este es menor a 100 % de descuento se dispondr&aacute; del proceso de la Emisi&oacute;n Masiva sino Env&iacute;o Cuadro P&oacute;liza.');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('cd_proceso_campania');
    vIndicesCuerpoDt.push('cd_campania');
    vIndicesCuerpoDt.push('nu_consecutivo');
    vIndicesCuerpoDt.push('ca_registros');
    vIndicesCuerpoDt.push('fe_proceso');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    return vRetorno;
}