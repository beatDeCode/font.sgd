function fnDataOptima(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('Edad|Rango de edad de los registros de la remesa.')
    vNombresCabeceraDt.push('Registros|Cantidad de registros por rango de edad.')
    vNombresCabeceraDt.push('Descuento|Porcentaje de Descuento comercial asignado para el Rango de Edad');
    vNombresCabeceraDt.push('%| Porcentaje de la cantidad de Registros de la Data &Oacute;ptima.');
    vNombresCabeceraDt.push('Acciones|Botones accionables, (Dist.) que representa la distribuci&oacute;n por edad del rango de edad y (P. T&eacute;cnicos) que habilita el proceso t&eacute;cnico para el rango de edad.');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('de_rango');
    vIndicesCuerpoDt.push('ca_registros');
    vIndicesCuerpoDt.push('po_comercial');
    vIndicesCuerpoDt.push('po_registros');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    return vRetorno;
}
function fnDataNoOptima(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('Motivo|Motivo de la variable de estudio para la data no &oacute;ptima.')
    vNombresCabeceraDt.push('Registros|Cantidad de registros por Motivo.')
    vNombresCabeceraDt.push('Detalle|Boton accionable que descarga el de la data detalle en excel.');
 
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('de_titulo');
    vIndicesCuerpoDt.push('ca_registros');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    return vRetorno;
}

function fnProcesosTecnicos(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('C&oacute;digo|C&oacute;digo del proceso t&eacute;cnico asignado.')
    vNombresCabeceraDt.push('Suma Aseg.|Suma Asegurada');
    vNombresCabeceraDt.push('Fecha Inicial|Fecha de inicio del proceso t&eacute;cnico.')
    vNombresCabeceraDt.push('Edad|Rango de edad seleccionado del proceso t&eacute;cnico.')
    vNombresCabeceraDt.push('Registros|Cantidad de registros del proceso t&eacute;cnico');
    vNombresCabeceraDt.push('% Comercial|Porcentaje de descuento comercial asignado para el proceso t&eacute;cnico.');
    vNombresCabeceraDt.push('%| Porcentaje de la cantidad de registros totales de los procesos t&eacute;cnicos.');
    vNombresCabeceraDt.push('Fases 1|Comprende la ejecucci&oacute;n de (Solicitud de Seguros o Campa&ntilde;a) dependiendo del porcentaje comercial, si este es menor a 100 % de descuento inicia el proceso de Campa&ntilde;a sino Solicitud de Seguros.');
    vNombresCabeceraDt.push('Fases 2|Comprende la ejecucci&oacute;n de (Emisi&oacute;n Masiva o Solicitud de Seguros) dependiendo del porcentaje comercial, si este es menor a 100 % de descuento se dispondr&aacute; del proceso de Solicitud de Seguros sino de la Emisi&oacute;n Masiva.');
    vNombresCabeceraDt.push('Fases 3|Comprende la ejecucci&oacute;n de (Emisi&oacute;n Masiva o Env&iacute;o Cuadro P&oacute;liza) dependiendo del porcentaje comercial, si este es menor a 100 % de descuento se dispondr&aacute; del proceso de la Emisi&oacute;n Masiva sino Env&iacute;o Cuadro P&oacute;liza.');
    vNombresCabeceraDt.push('Fases 4|Comprende la ejecucci&oacute;n de (Campa&ntilde;ao Env&iacute;o Cuadro P&oacute;liza) dependiendo del porcentaje comercial, si este es menor a 100 % de descuento se dispondr&aacute; del proceso de Env&iacute;o Cuadro P&oacute;liza sino Campa&ntilde;a.');
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('cd_proceso_tecnico');
    vIndicesCuerpoDt.push('mt_suma_asegurada');
    vIndicesCuerpoDt.push('fe_proceso');
    vIndicesCuerpoDt.push('de_rango');
    vIndicesCuerpoDt.push('ca_registros');
    vIndicesCuerpoDt.push('po_descuento');
    vIndicesCuerpoDt.push('po_registros');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    return vRetorno;
}
function fnOptimaRangoEdad(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('Rango')
    vNombresCabeceraDt.push('Registros')
    vNombresCabeceraDt.push('%');
 
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('de_rango_edad');
    vIndicesCuerpoDt.push('ca_registros');
    vIndicesCuerpoDt.push('po_registros');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    return vRetorno;
}

function fnProcesoTecnicoForms(){
    var vInputs=[];
    vInputs.push('mt_suma_asegurada|select|link:MCoreRemesa-vSumasAseguradas|Rol|6');
    vInputs.push('po_descuento|select|link:MCoreRemesa-vPorcentajesComerciales|Rol|6');
    return vInputs;
    
}
function fnBalanceRemesa(){
    var vRetorno=[];
    var vNombresCabeceraDt=[];
    vNombresCabeceraDt.push('Registros')
    vNombresCabeceraDt.push('Descripci&oacute;n')
 
    var vIndicesCuerpoDt=[];
    vIndicesCuerpoDt.push('ca_registros');
    vIndicesCuerpoDt.push('text');
    vRetorno.push(vNombresCabeceraDt);
    vRetorno.push(vIndicesCuerpoDt);
    return vRetorno;
}