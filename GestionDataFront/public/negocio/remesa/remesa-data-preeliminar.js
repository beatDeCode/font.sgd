var vServer='http://10.10.0.202:8081/';
//var vServer='http://localhost:9081/';
function fnTablaDataOptima(pCdRemesa){
    var vDatatable='';
    var vArmadoDatatable='';
    var vNombreDataTable='';
    var vDivParaAnexaDataTable=$('div[id="datatable1-data-optima"]');

    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            fnModalXs('<div class="spinner offset-md-5"></div><p>Cargado Tabla de Data &Oacute;ptima</p> ');
            $.ajax({
                url:'/sgd.remesa.data-optima/'+pCdRemesa,
                type:'GET',
            }).done(function(response){
                
                var vFuncionController='fnDataOptima';
                vDivParaAnexaDataTable.html('');
                vNombreDataTable='dt-data-optima';
                var vIndices=window[vFuncionController]()[1];
                vArmadoDatatable=fnArmarTablaDtTooltips(vFuncionController,vNombreDataTable);
                vDivParaAnexaDataTable.append('<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Data Preliminar &Oacute;ptima</b></li>'+'<hr>'+vArmadoDatatable);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,10));
                var vContadorData=0;
                for(var b=0;b<response.length;b++){
                    var vCantidadRegistros=parseInt(response[b]['ca_registros']);
                    vContadorData+=vCantidadRegistros;
                    var vArrayValores=[];
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                    if(vCantidadRegistros>0){
                        vArrayValores.push('<a class="badge bg-info" style="text-decoration:none;" onclick="fnMostrarPorcentajesEdades('+pCdRemesa+','+response[b]['cd_rango']+',\''+response[b]['de_rango']+'\')" >Dist.</a> '+
                        '<a class="badge bg-info" style="text-decoration:none;" onclick="fnProcesoTecnico('+pCdRemesa+','+response[b]['cd_rango']+',\''+response[b]['ca_registros']+'\')" >P. Tecnico</a>');
                    }else{
                        vArrayValores.push('-');
                    }
                    vDatatable.row.add(vArrayValores).draw(false);
                }
                var vDivResultadoFinal=$('div[id="adicional1-data-optima"]');
                vDivResultadoFinal.html('');
                vDivResultadoFinal.append(fnArmarWidget(vContadorData,'Total','success'));
                swal.close();
                
            });

        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}
function fnTablaDataNoOptima(pCdRemesa){
    var vDatatable='';
    var vArmadoDatatable='';
    var vNombreDataTable='';
    var vDivParaAnexaDataTable=$('div[id="datatable2-data-optima"]');
    fnModalXs('<div class="spinner offset-md-5"></div><p>Cargado Tabla de Data no &Oacute;ptima</p> ');
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            
            $.ajax({
                url:'/sgd.remesa.data-no-optima/'+pCdRemesa,
                type:'GET',
            }).done(function(response){
                
                var vFuncionController='fnDataNoOptima';
                vDivParaAnexaDataTable.html('');
                vNombreDataTable='dt-data-no-optima';
                var vIndices=window[vFuncionController]()[1];
                vArmadoDatatable=fnArmarTablaDtTooltips(vFuncionController,vNombreDataTable);
                vDivParaAnexaDataTable.append('<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Data Preliminar no &Oacute;ptima</b></li>'+'<hr>'+vArmadoDatatable);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,10));
                var vContadorData=0;
                //console.log(response);
                for(var b=0;b<response.length;b++){
                    var vArrayValores=[];
                    var vCantidadRegistros=parseInt(response[b]['ca_registros']);
                    vContadorData+=vCantidadRegistros;
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                    if(vCantidadRegistros>0){
                        vArrayValores.push('<a class="badge bg-success" style="text-decoration:none;" onclick="fnDescargarExcelDataNoOptima('+pCdRemesa+',\''+response[b]['cd_data_no_optima']+'\')" >Detalle</a>');
                    }else{
                        vArrayValores.push('-');
                    }
                    
                    var vDivResultadoFinal=$('div[id="adicional2-data-optima"]');
                    vDivResultadoFinal.html('');
                    vDivResultadoFinal.append(fnArmarWidget(vContadorData,'Total','danger'));
                    var vNodo=vDatatable.row.add(vArrayValores).draw(false);
                    //$(vNodo.node()).attr('id',response[b][vIdPojo]);
                    //vDatatable.row.add(vArrayValores).draw(false);
                }
                swal.close();
            });
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnBuscarRemesa(){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            var vOptionSelected=$('select[name="cd_remesa"] option:selected').val();
            if(vOptionSelected){

                $.ajax({
                    url:'/sgd.remesa.detalle/'+vOptionSelected,
                    type:'GET'
                }).done(function(response){
                    fnModalXs('<div class="spinner offset-md-5"></div><p>Cargando data.</p> ');
                    var vDivDetalleRemesa=$('div[id="detalle-remesa"]');
                    vDivDetalleRemesa.html('');
                    vDivDetalleRemesa.append(fnArmarTarjetaConTitulos(response)+'<input type="hidden" value="'+vOptionSelected+'" name="var:x:cd_remesa">');
                    vDivDetalleRemesa.append(
                        '<div class="col-md-6"><li style="padding-left:10px;font-size:14px;"><b>Distribuci&oacute;n</b>:'+
                            ' <a class="badge bg-dark" style="text-decoration:none;" onclick="fnMostrarPorcentajesGlobal('+vOptionSelected+')">Global</a> '+
                            ' <a class="badge bg-dark" style="text-decoration:none;" onclick="fnMostrarPorcentajesDataOptima('+vOptionSelected+')">&Oacute;ptima</a> '+
                            ' <a class="badge bg-dark" style="text-decoration:none;" onclick="fnMostrarPorcentajesNoDataOptima('+vOptionSelected+')">No &Oacute;ptima</a> '+
                        '</li></div>'+
                        '<div class="col-md-6"><li style="padding-left:10px;font-size:14px;"><b>Gestion de la Remesa</b>:'+
                            ' <a class="badge bg-dark" style="text-decoration:none;" onclick="fnMostrarBalanceBasico('+vOptionSelected+')"> Balance</a> '+
                            ' <a class="badge bg-dark" style="text-decoration:none;" onclick="fnGenerarBalanceRemesa('+vOptionSelected+','+response[0]['value']+')"> Balance Ejecutivo</a> '+
                        '</li></div><br>'+
                        '<hr> '+
                        '<div class="col-md-12">'+
                            '<center>'+
                            '<button class="btn btn-sm btn-dark" onclick="fnRenovarPaneles('+vOptionSelected+')" type="button">'+
                              '<svg class="icon me-2">'+
                                '<use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-contrast"></use>'+
                              '</svg>Reiniciar Tableros'+
                            '</button>'+
                            '</center>'+
                        '</div>'
                        //'<div class="row"><div class="col-md-3"id="div-balance"></div>'
                        );
                    //fnGenerarBalanceRemesa(vOptionSelected);
                    //vDivDetalleRemesa.append(fnArmarTarjetaConListGroups(response));
                    swal.close();
                    fnTablaDataOptima(vOptionSelected);
                    fnTablaDataNoOptima(vOptionSelected);
                    fnTablaProcesosTecnicos(vOptionSelected);
                    $('select[name="cd_remesa"]').val(vOptionSelected);
                    //
                    var vPanelRemesa=$('div[id="panel-remesa"]');
                    var vTitulo1=$('div[id="1"]');
                    var vTitulo2=$('div[id="2"]');
                    var vBodyAcordion=$('div[id="col-acordion-data-optima"]');
                    var vButtonAcordion=$('button[id="btn-acordion-data-optima"]');
                    vButtonAcordion.attr('aria-expanded','true');
                    vButtonAcordion.removeClass('collapsed');
                    vBodyAcordion.addClass('show');
                    vPanelRemesa.css('display','block');
                    vTitulo1.css('display','block');
                    vTitulo2.css('display','block');
                })
                .fail(function(a,b,c){
                    console.log(a,b,c);
                })   
            }
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnBotonesProcesosTecnicos(pSolicitudSeguros,pCuadroPoliza,pEmisionMasiva,pCampania,pPorcentaje,pCdProcesoTecnico,pCantidaRegistros){
    var vBotones='';
    var vBotonSS='<div class="badge bg-danger">Sol. Seguros</div>';
    var vBotonEM='<div class="badge bg-danger">Emisi&oacute;n</div>';
    var vBotonCD='<div class="badge bg-danger">Cuadro P&oacute;liza</div>';
    var vBotonSC='<div class="badge bg-danger">Campa&ntilde;a</div>';
    if(pPorcentaje<100){
        if(pCampania==0){vBotonSC='<a class="badge bg-warning" onclick="fnSolicitudCampania('+pCdProcesoTecnico+','+pCantidaRegistros+')">Campa&ntilde;a</a>';}
        if(pCampania==1 || pCampania==99){vBotonSC='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',4,'+pCampania+')">Det. Campaña</a>';}
        /*if(pCampania==1 && pSolicitudSeguros==0){vBotonSS='<a class="badge bg-warning" onclick="fnSolicitudSeguros('+pCdProcesoTecnico+','+pCantidaRegistros+')">Sol. Seguros</a>';}
        if(pCampania==1 && pSolicitudSeguros==1){vBotonSS='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',1,'+pSolicitudSeguros+')">Det. Solictud</a>';}
        if(pSolicitudSeguros==1 && pEmisionMasiva==0){vBotonEM='<a class="badge bg-warning" onclick="fnEmisionMasiva('+pCdProcesoTecnico+','+pCantidaRegistros+')">Emisi&oacute;n</a>';}
        if(pSolicitudSeguros==1 && (pEmisionMasiva==99 || pEmisionMasiva==1) ){vBotonEM='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',2,'+pEmisionMasiva+')">Det. Emisi&oacute;n</a>';}
        if(pEmisionMasiva==1  && pCuadroPoliza==0){vBotonCD='<a class="badge bg-warning" onclick="fnEnvioCuadroPoliza('+pCdProcesoTecnico+','+pCantidaRegistros+')">Cuadro P&oacute;liza</a>';}
        if(pEmisionMasiva==1 && pCuadroPoliza==1){vBotonCD='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',3,'+pCuadroPoliza+')">Det. Cuadro P&oacute;liza</a>';}
        */
        //vBotones=vBotonSC+'$'+vBotonSS+'$'+vBotonEM+'$'+vBotonCD;
        vBotones=vBotonSC+'$N/A$N/A$N/A';
    }else{
        if(pSolicitudSeguros==0){vBotonSS='<a class="badge bg-warning" onclick="fnSolicitudSeguros('+pCdProcesoTecnico+','+pCantidaRegistros+')">Sol. Seguros</a>';}
        if(pSolicitudSeguros==1){vBotonSS='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',1,'+pSolicitudSeguros+')">Det. Solictud</a>';}
        if(pSolicitudSeguros==1 && pEmisionMasiva==0){vBotonEM='<a class="badge bg-warning" onclick="fnEmisionMasiva('+pCdProcesoTecnico+','+pCantidaRegistros+')">Emisi&oacute;n</a>';}
        if(pSolicitudSeguros==1 && (pEmisionMasiva==99 || pEmisionMasiva==1)){vBotonEM='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',2,'+pEmisionMasiva+')">Det. Emisi&oacute;n</a>';}
        if(pEmisionMasiva==1 && pCuadroPoliza==0){vBotonCD='<a class="badge bg-warning" onclick="fnEnvioCuadroPoliza('+pCdProcesoTecnico+','+pCantidaRegistros+')">Cuadro P&oacute;liza</a>';}
        if(pEmisionMasiva==1 && pCuadroPoliza==1){vBotonCD='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',3,'+pCuadroPoliza+')">Det. Cuadro P&oacute;liza</a>';}
        if(pCampania==0 && pCuadroPoliza==1){vBotonSC='<a class="badge bg-warning" onclick="fnSolicitudCampania('+pCdProcesoTecnico+','+pCantidaRegistros+')">Campa&ntilde;a</a>';}
        if(pCampania==1 && pCuadroPoliza==1){vBotonSC='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',4,'+pCampania+')">Det. Campaña</a>';}
        vBotones=vBotonSS+'$'+vBotonEM+'$'+vBotonCD+'$'+vBotonSC;
    }
    return vBotones;
}
function fnTablaProcesosTecnicos(pCdRemesa){
    var vDatatable='';
    var vArmadoDatatable='';
    var vNombreDataTable='';
    var vDivParaAnexaDataTable=$('div[id="datatable1-procesos-tecnicos"]');
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            
            $.ajax({
                url:'/sgd.remesa.procesos-tecnicos/'+pCdRemesa,
                type:'GET',
            }).done(function(response){
                fnModalXs('<div class="spinner offset-md-5"></div><p>Cargando Tabla de Procesos T$eacute;cnicos</p> ');
                var vFuncionController='fnProcesosTecnicos';
                vDivParaAnexaDataTable.html('');
                vNombreDataTable='dt-procesos-tecnicos';
                var vIndices=window[vFuncionController]()[1];
                vArmadoDatatable=fnArmarTablaDtTooltips(vFuncionController,vNombreDataTable);
                vDivParaAnexaDataTable.append('<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Procesos T&eacute;cnicos</b></li>'+'<hr>'+vArmadoDatatable);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,10));
                var vContadorData=0;
                for(var b=0;b<response.length;b++){
                    var vArrayValores=[];
                    vContadorData+=parseInt(response[b]['ca_registros']);
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                    var vFases=
                    fnBotonesProcesosTecnicos(
                        response[b]['in_solicitud_seguros'],
                        response[b]['in_envio_cuadro_poliza'],
                        response[b]['in_emision_masiva'],
                        response[b]['in_solicitud_campania'],
                        parseInt(response[b]['po_descuento']),
                        response[b]['cd_proceso_tecnico'],
                        response[b]['ca_registros']);
                    vArrayFases=vFases.split('$');
                    vArrayValores.push(vArrayFases[0]);
                    vArrayValores.push(vArrayFases[1]);
                    vArrayValores.push(vArrayFases[2]);
                    vArrayValores.push(vArrayFases[3]);
                    var vNodo=vDatatable.row.add(vArrayValores).draw(false);
                }
                var vDivResultadoFinal=$('div[id="adicional1-procesos-tecnicos"]');
                vDivResultadoFinal.html('');
                vDivResultadoFinal.append(fnArmarWidget(vContadorData,'Total','danger'));
                swal.close();
            });
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}
function fnMostrarPorcentajesEdades(pCdRemesa,pCdRangoEdad,pDeRango){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            $.ajax({
                url:'/sgd.remesa.porcentajes-edad/'+pCdRemesa+'/'+pCdRangoEdad,
                type:'GET'
            }).done(function(response){
                fnModalXs('<div class="spinner offset-md-5"></div><p>Cargado Porcentaje Por Rango de Edad</p> ');
                swal.close();
                fnModalXs('<div id="porcentajes-edad"></div>');
                var vDivParaAnexaDataTable=$('div[id="porcentajes-edad"]');
                var vFuncionController='fnOptimaRangoEdad';
                vNombreDataTable='dt-porcentajes-edad';
                var vIndices=window[vFuncionController]()[1];
                var vArmadoDatatable=fnArmarTablaDtTooltips(vFuncionController,vNombreDataTable);
                var vTabla=
                    '<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Porcentaje '+pDeRango+'</b></li>'+
                    '<a class="badge bg-success" onclick="fnDescargarExcelDataOptima('+pCdRemesa+','+pCdRangoEdad+')">Descargar Excel</a>'+'<hr>'+
                    vArmadoDatatable; 
                vDivParaAnexaDataTable.append(vTabla);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,10));
                var vContadorData=0;
                for(var b=0;b<response.length;b++){
                    var vArrayValores=[];
                    vContadorData+=parseInt(response[b]['ca_registros']);
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                vDatatable.row.add(vArrayValores).draw(false);
                }
                vDivParaAnexaDataTable.append('Total Data: '+vContadorData);
                //
            
            });
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnMostrarPorcentajesGlobal(pCdRemesa){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            $.ajax({
                url:'/sgd.remesa.porcentajes-global/'+pCdRemesa,
                type:'GET'
            }).done(function(response){
                fnModalXs('<div class="spinner offset-md-5"></div><p>Cargado Porcentaje Global</p> ');
                swal.close();
                fnModalXs('<div id="porcentajes-edad"></div>');
                var vDivParaAnexaDataTable=$('div[id="porcentajes-edad"]');
                var vFuncionController='fnOptimaRangoEdad';
                vNombreDataTable='dt-porcentajes-edad';
                var vIndices=window[vFuncionController]()[1];
                var vArmadoDatatable=fnArmarTablaDtTooltips(vFuncionController,vNombreDataTable);
                var vTabla='<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Porcentaje Global</b></li>'+'<hr>'+vArmadoDatatable;
                vDivParaAnexaDataTable.append(vTabla);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,10));
                var vContadorData=0;
                for(var b=0;b<response.length;b++){
                    var vArrayValores=[];
                    vContadorData+=parseInt(response[b]['ca_registros']);
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                vDatatable.row.add(vArrayValores).draw(false);
                }
                vDivParaAnexaDataTable.append('Total Data: '+vContadorData);
                //
            })
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnMostrarPorcentajesDataOptima(pCdRemesa){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            $.ajax({
                url:'/sgd.remesa.porcentajes-data-optima/'+pCdRemesa,
                type:'GET'
            }).done(function(response){
                fnModalXs('<div class="spinner offset-md-5"></div><p>Cargado Porcentaje Data &Oacute;ptima</p> ');
                swal.close();
                fnModalXs('<div id="porcentajes-edad"></div>');
                var vDivParaAnexaDataTable=$('div[id="porcentajes-edad"]');
                var vFuncionController='fnOptimaRangoEdad';
                vNombreDataTable='dt-porcentajes-edad';
                var vIndices=window[vFuncionController]()[1];
                var vArmadoDatatable=fnArmarTablaDtTooltips(vFuncionController,vNombreDataTable);
                var vTabla='<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Porcentaje Data &Oacute;ptima </b></li>'+'<hr>'+vArmadoDatatable;
                vDivParaAnexaDataTable.append(vTabla);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,10));
                var vContadorData=0;
                for(var b=0;b<response.length;b++){
                    var vArrayValores=[];
                    vContadorData+=parseInt(response[b]['ca_registros']);
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                vDatatable.row.add(vArrayValores).draw(false);
                }
                vDivParaAnexaDataTable.append('Total Data: '+vContadorData);
            })
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnMostrarPorcentajesNoDataOptima(pCdRemesa){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        console.log(response.length);
        if(response.length>2){
            $.ajax({
                url:'/sgd.remesa.porcentajes-data-nooptima/'+pCdRemesa,
                type:'GET'
            }).done(function(response){
                fnModalXs('<div class="spinner offset-md-5"></div><p>Cargado Porcentaje Data no &Oacute;ptima</p> ');
                swal.close();
                fnModalXs('<div id="porcentajes-edad"></div>');
                var vDivParaAnexaDataTable=$('div[id="porcentajes-edad"]');
                var vFuncionController='fnOptimaRangoEdad';
                vNombreDataTable='dt-porcentajes-edad';
                var vIndices=window[vFuncionController]()[1];
                var vArmadoDatatable=fnArmarTablaDtTooltips(vFuncionController,vNombreDataTable);
                var vTabla='<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Porcentaje Data no &Oacute;ptima </b></li>'+'<hr>'+vArmadoDatatable;
                vDivParaAnexaDataTable.append(vTabla);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,10));
                var vContadorData=0;
                for(var b=0;b<response.length;b++){
                    var vArrayValores=[];
                    vContadorData+=parseInt(response[b]['ca_registros']);
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                vDatatable.row.add(vArrayValores).draw(false);
                }
                vDivParaAnexaDataTable.append('Total Data: '+vContadorData);
                //
            })
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnProcesoTecnico(pCdRemesa,pCdRango,PCantidadRegistros){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            var vMensaje='Importante|La <b>DATA</b> pasar&aacute; <b>Procesos T&eacute;cnicos</b>, es importante chequear cada uno de los p&aacute;rametros <b>(Suma Asegurada, Porcentaje Comercial, Cantidad de registros)</b>, antes de proceder con la operacion.'
			var vArrayResumen=[];
			vArrayResumen.push(vMensaje);
            var vModal=fnModalXsCentrado(
                '<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Procesos T&eacute;cnicos </b></li>'+'<hr>'+
                '<div id="forms-ajax"></div><div id="forms"></div>'+
                fnResumenCarga(vArrayResumen,'Procesos T&eacute;cnicos')
            );
            fnArmarSelectsPorAjaxCustom('fnProcesoTecnicoForms');
            var vDiv=$('div[id="forms"]');
            vDiv.html('');
            vDiv.append(fnArmarFormularioDivisorDeRegistros(PCantidadRegistros,'ca_registros'));

            vModal.then((response) =>{
	            if(response.isConfirmed){
                    console.log(response);
                    var vCantidadRegistros=$('select[name="ca_registros"] option:selected').val();
                    var vMtSumaAsegurada=$('select[name="mt_suma_asegurada"] option:selected').val();
                    var vPorcentajeComercial=$('select[name="po_comercial"] option:selected').val();
                    $.ajax({
                        url:'/sgd.proceso-tecnico.agregar/'+pCdRemesa+'/'+pCdRango+
                            '/'+vMtSumaAsegurada+'/'+vPorcentajeComercial+'/'+vCantidadRegistros,
                        type:'GET'
                    }).done(function(response){
                        if(response.length==1){
                            fnModalXsCheck();
                            setTimeout(function(){
                                fnBuscarRemesa();
                            },2500); 
                        }else{
                            fnModalXs('Existe un error en el proceso.');
                        }
                    });

	            }   
	        });
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}
function fnDescargarExcelDataNoOptima(pCdRemesa, pCdDataNoOptima){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            if(pCdDataNoOptima=='I'){
                window.location.replace(vServer+'sgd.reportes-xlsx/GESTION_REMESA_DNO2L/CD_REMESA-'+pCdRemesa+'-CD_DATA_NO_OPTIMA-'+pCdDataNoOptima);
            }else{
                window.location.replace(vServer+'sgd.reportes-xlsx/GESTION_REMESA_DNO1L/CD_REMESA-'+pCdRemesa+'-CD_DATA_NO_OPTIMA-'+pCdDataNoOptima);
            }
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}
function fnDescargarExcelDataOptima(pCdRemesa, pCdRango){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            window.location.replace(vServer+'sgd.reportes-xlsx/JRSGD01/CD_REMESA-'+pCdRemesa+'-CD_RANGO_EDAD-'+pCdRango);
            
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnSolicitudCampania(pProcesoTecnico,pRegistros){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            
            var vMensaje=
            'Importante| Se ejecutar&aacute; el proceso <b>Solicitud de Campaña</b> para el proceso # <b>'+
                pProcesoTecnico+
            '</b>, con <b>'+pRegistros+'</b> registros.';
			var vArrayResumen=[];
			vArrayResumen.push(vMensaje);
            fnModalXsParaCarga(
                '<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Solicitud de Campa&ntilde;a</b></li>'+
                    '<hr>'+
                fnResumenCarga(vArrayResumen,'Solicitud de Campa&ntilde;a')  
            ).then((response) =>{
	            if(response.isConfirmed){
                    console.log(response);
                    $.ajax({
                        url:'/sgd.proceso-tecnico.actualizar/'+pProcesoTecnico+'/4',
                        type:'GET'
                    }).done(function(response){
                        if(response.length==1){
                            fnModalXsCheck();
                            setTimeout(function(){
                                fnBuscarRemesa();
                            },2500); 
                        }else{
                            console.log(response);
                            fnModalXs('Existe un error en el proceso.');
                        }
                    }).fail(function(a,b,c,){
                        console.log(a,b,c);
                    });

	            }   
	        });
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}
function fnSolicitudSeguros(pProcesoTecnico,pRegistros){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            
            var vMensaje=
            'Importante| Se ejecutar&aacute; <b>Solicitud de Seguros</b> para el proceso # <b>'+
                pProcesoTecnico+
            '</b>, con <b>'+pRegistros+'</b> registros.';
			var vArrayResumen=[];
			vArrayResumen.push(vMensaje);
            fnModalXsParaCarga(
                '<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Solicitud de Seguros</b></li>'+
                    '<hr>'+
                fnResumenCarga(vArrayResumen,'Solicitud de Seguros')
            ).then((response) =>{
	            if(response.isConfirmed){
                    $.ajax({
                        url:'/sgd.proceso-tecnico.actualizar/'+pProcesoTecnico+'/1',
                        type:'GET'
                    }).done(function(response){
                        if(response.length==1){
                            fnModalXsCheck();
                            setTimeout(function(){
                                fnBuscarRemesa();
                            },2500); 
                        }else{
                            fnModalXs('Existe un error en el proceso.');
                        }
                    });

	            }   
	        });
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}
function fnEmisionMasiva(pProcesoTecnico,pRegistros){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            
            var vMensaje=
            'Importante| Se ejecutar&aacute; <b>Emisi&oacute;n Masiva</b> para el proceso # <b>'+
                pProcesoTecnico+
            '</b>, con <b>'+pRegistros+'</b> registros.'
			var vArrayResumen=[];

			vArrayResumen.push(vMensaje);
            fnModalXsParaCarga(
                '<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Emisi&oacute;n Masiva</b></li>'+
                    '<hr>'+
                fnResumenCarga(vArrayResumen,'Emisi&oacute;n Masiva')
                ).then((response) =>{
                    if(response.isConfirmed){
                        $.ajax({
                            url:'/sgd.proceso-tecnico.valida-emision/'+pProcesoTecnico,
                            type:'GET',
                        }).done(function(response){
                            console.log(response);
                            var vValidacion=response[0]['validacion'];
                            var vFecha=response[0]['fe_proceso'];
                            var vExisteOtroProcesoEmision=response[0]['valida_proceso'];
                            if(vExisteOtroProcesoEmision==1){
                                fnModalXs('Existe un Emisi&oacute;n masiva corriendo en la cola para el proceso tecnico #.'+pProcesoTecnico);
                            }else{
                                if(vValidacion==0){
                                    $.ajax({
                                        url:'/sgd.proceso-tecnico.actualizar/'+pProcesoTecnico+'/2',
                                        type:'GET'
                                    }).done(function(response){
                                        if(response.length==1){
                                            fnModalXsCheck();
                                            setTimeout(function(){
                                                fnBuscarRemesa();
                                            },2500); 
                                        }else{
                                            fnModalXs('Existe un error en el proceso.');
                                        }
                                    });
                                }else{
                                    fnModalXs('El proceso t&eacute;cnico no est&aacute; disponible, se puede puede realizar el dia '+vFecha+' .');
                                }
                            }
                            
                        });
                    }
                });
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}
function fnEnvioCuadroPoliza(pProcesoTecnico,pRegistros){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            
            var vMensaje=
            'Importante| Se ejecutar&aacute; <b>Cuadro P&oacute;liza </b> para el proceso # <b>'+
                pProcesoTecnico+
            '</b>, con <b>'+pRegistros+'</b> registros.';
    		var vArrayResumen=[];
			vArrayResumen.push(vMensaje);
            fnModalXsParaCarga(
                '<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Cuadro P&oacute;liza</b></li>'+
                    '<hr>'+
                fnResumenCarga(vArrayResumen,'Cuadro P&oacute;liza')
            ).then((response) =>{
                if(response.isConfirmed){
                    $.ajax({
                        url:'/sgd.proceso-tecnico.actualizar/'+pProcesoTecnico+'/3',
                        type:'GET'
                    }).done(function(response){

                        if(response.length==1){
                            fnModalXsCheck();
                            setTimeout(function(){
                                fnBuscarRemesa();
                            },2500); 
                        }else{
                            fnModalXs('Existe un error en el proceso.');
                        }
                    });

                }   
            });;
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnMostrarEstatusEmision(pCdProcesoTecnico){
    $.ajax({
        url:'/sgd.proceso-tecnico.status-emision/'+pCdProcesoTecnico,
        type:'GET'
    }).done(function(response){
        var vColor='bg-warning';
        var vDiv=$('div[id="div-status-emision"]');
        if(response=='En Ejecucion'){
            vColor='bg-success';
        }
        if(response=='Culminado'){
            vColor='bg-info';
        }
        vDiv.html('');
        vDiv.append(
            '<b>Estatus del proceso</b>'+'<br>'+
            '<a class="badge '+vColor+'" href="#">'+response+'</a>'
        );

    });
}
function fnDetalleProceso(pCdProcesoTecnico,pRegistros,pCondicion,pCdEstatus){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            var vFunction='';
            var vTitulo='';
            var vReporte='';
            var vHtml='';
            var vParametro='CD_PROCESO_TECNICO-'+pCdProcesoTecnico;
            var vMensaje='Importante | Para ver el detalle del proceso es necesario oprimir el boton de '
            if(pCondicion==1){
                vTitulo='Solicitud de Seguros';
                vReporte='JRPTSS';
                vHtml='<a class="badge bg-success" onclick="fnDescargaReporteProcesoTecnico(\''+vReporte+'\',\''+vParametro+'\')">Detalle Excel </a>'
                ;
            }
            if(pCondicion==2){
                vTitulo='Emisi&oacute;n Masiva';
                vReporte='JRPTEM';
                if(pCdEstatus==99){
                    vHtml='<a class="badge bg-success" onclick="fnDescargaReporteProcesoTecnico(\''+vReporte+'\',\''+vParametro+'\')">Detalle Excel </a>'+
                        '<hr>'+
                        '<b>Log </b> <br> <a class="badge bg-success" href="/sgd.proceso-tecnico.log-emision/'+pCdProcesoTecnico+'">Log de Proceso</a>'+
                        '<hr>'+
                        '<div id="div-status-emision"></div>'+
                        '<hr>'+
                    '<a class="badge bg-warning" onclick="fnEmisionMasiva('+pCdProcesoTecnico+','+pRegistros+')">Re-Procesar</a>';
                }else{
                    vHtml='<a class="badge bg-success" onclick="fnDescargaReporteProcesoTecnico(\''+vReporte+'\',\''+vParametro+'\')">Detalle Excel </a>'+
                    '<hr>'+
                    '<b>Log </b> <br> <a class="badge bg-success" href="/sgd.proceso-tecnico.log-emision/'+pCdProcesoTecnico+'">Log de Proceso</a>'+
                    '<hr>'+
                    '<div id="div-status-emision"></div>'
                    ;
                }
            }
            if(pCondicion==3){
                vTitulo='Cuadro P&oacute;liza';
                vReporte='JRPTCP';
                vHtml='<a class="badge bg-success" onclick="fnDescargaReporteProcesoTecnico(\''+vReporte+'\',\''+vParametro+'\')">Detalle Excel </a>';
            }
            if(pCondicion==4){
                vTitulo='Solicitud de Campa&ntilde;a';
                vReporte='JRPTSC';
                vHtml='<a class="badge bg-success" onclick="fnDescargaReporteProcesoTecnico(\''+vReporte+'\',\''+vParametro+'\')">Detalle Excel </a>';
            }
            var vTituloPrincipal='<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Detalle del Proceso # '+pCdProcesoTecnico+' de $vTitulo$</b></li>';
            var vReemplazo=vTituloPrincipal.replace('$vTitulo$',vTitulo);

            fnModalXs(
                    vReemplazo+
                        '<hr>'+
                        vMensaje+
                        '<hr>'+
                        vHtml
                        

                    );
            if(pCondicion==2){fnMostrarEstatusEmision(pCdProcesoTecnico)}

        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}
function fnDescargaReporteProcesoTecnico(pReporte, pParametros){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            window.location.replace(vServer+'sgd.reportes-xlsx/'+pReporte+'/'+pParametros);
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}
function fnGenerarBalanceRemesa(pCdRemesa,pCdAliado ){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            window.location.replace(vServer+'sgd.reportes-xlsx/JRBALANCEREMESA/CD_REMESA-'+pCdRemesa+'-CD_ALIADO-'+pCdAliado);
            
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnMostrarBalanceBasico(pCdRemesa){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        console.log(response.length);
        if(response.length>2){
            $.ajax({
                type:'GET',
                url:'sgd.remesa.balance-basico/'+pCdRemesa
            }).done(function(response){
                if(response.length){
                    fnModalXs('<div class="spinner offset-md-5"></div><p>Cargando Balance B&aacute;sico de la Remesa.</p> ');
                    swal.close();
                    fnModalXs('<div id="div-balance"></div>');
                    var vArmadoDatatable=fnArmarTablaDt('fnBalanceRemesa','dt-balance-remesa');
                    var vDivParaTable=$('div[id="div-balance"]');
                    vDivParaTable.html('');
                    vDivParaTable.append(
                            '<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Balance B&aacute;sico de la Remesa </b></li>'+'<hr>'+
                        vArmadoDatatable);
                    var vElementoDataTable=$('table[id="dt-balance-remesa"]');
                    var vDataTable=vElementoDataTable.DataTable(fnConfiguracionDataTable(false,false,5));
                    var vArrayLlenadoDataTable=[];
                    for(var indice=0;indice<response.length;indice++){
                        vArrayLlenadoDataTable.push(response[indice]['ca_registros']);
                        vArrayLlenadoDataTable.push(response[indice]['text']);
                        vDataTable.row.add(vArrayLlenadoDataTable).draw(false);
                        vArrayLlenadoDataTable=[];
                    }
                }
            }).fail(function(a,b,c){
                console.log(a,b,c);
            });

            /*$.ajax({
                url:'/sgd.remesa.porcentajes-data-nooptima/'+pCdRemesa,
                type:'GET'
            }).done(function(response){
                fnModalXs('<div class="spinner offset-md-5"></div><p>Cargado Porcentaje Data no &Oacute;ptima</p> ');
                swal.close();
                fnModalXs('<div id="porcentajes-edad"></div>');
                var vDivParaAnexaDataTable=$('div[id="porcentajes-edad"]');
                var vFuncionController='fnOptimaRangoEdad';
                vNombreDataTable='dt-porcentajes-edad';
                var vIndices=window[vFuncionController]()[1];
                var vArmadoDatatable=fnArmarTablaDtTooltips(vFuncionController,vNombreDataTable);
                var vTabla='<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Porcentaje Data no &Oacute;ptima </b></li>'+'<hr>'+vArmadoDatatable;
                vDivParaAnexaDataTable.append(vTabla);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,10));
                var vContadorData=0;
                for(var b=0;b<response.length;b++){
                    var vArrayValores=[];
                    vContadorData+=parseInt(response[b]['ca_registros']);
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                vDatatable.row.add(vArrayValores).draw(false);
                }
                vDivParaAnexaDataTable.append('Total Data: '+vContadorData);
                //
            })*/
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}
function fnRenovarPaneles(vCdRemesa){
    fnTablaDataOptima(vCdRemesa);
    fnTablaDataNoOptima(vCdRemesa);
    fnTablaProcesosTecnicos(vCdRemesa);
    $('select[name="cd_remesa"]').val(vCdRemesa);
    var vPanelRemesa=$('div[id="panel-remesa"]');
    var vTitulo1=$('div[id="1"]');
    var vTitulo2=$('div[id="2"]');
    var vBodyAcordion=$('div[id="col-acordion-data-optima"]');
    var vButtonAcordion=$('button[id="btn-acordion-data-optima"]');
    vButtonAcordion.attr('aria-expanded','true');
    vButtonAcordion.removeClass('collapsed');
    vBodyAcordion.addClass('show');
    vPanelRemesa.css('display','block');
    vTitulo1.css('display','block');
    vTitulo2.css('display','block');
}