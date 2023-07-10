var vServer='http://10.10.0.202:8081/';
//var vServer='http://localhost:8081/';
function fnDataPanelGeneral(pCdCampania,pCdProcesoTecnico){
    var vDatatable='';
    var vArmadoDatatable='';
    var vNombreDataTable='';
    var vDivParaAnexaDataTable=$('div[id="datatable1-panel-general"]');

    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            fnModalXs('<div class="spinner offset-md-5"></div><p>Cargando Tabla de Data &Oacute;ptima</p> ');
            $.ajax({
                url:'/sgd.campania.panel-general/'+pCdCampania+'/'+pCdProcesoTecnico,
                type:'GET',
            }).done(function(response){
                var vFuncionController='fnPanelGeneral';
                vDivParaAnexaDataTable.html('');
                vNombreDataTable='dt-panel-general';
                var vIndices=window[vFuncionController]()[1];
                
                vArmadoDatatable=fnArmarTablaDtTooltips(vFuncionController,vNombreDataTable);
                vDivParaAnexaDataTable.append('<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Panel General de la Campa&ntilde;a</b></li>'+'<hr>'+vArmadoDatatable);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,10));
                var vContadorData=0;
                for(var b=0;b<response.length;b++){
                    var vCantidadRegistros=parseInt(response[b]['ca_registros']);
                    vContadorData+=vCantidadRegistros;
                    var vArrayValores=[];
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                    if(vCantidadRegistros>0 && response[b]['in_decision_final']==0){
                        vArrayValores.push(
                        '<a class="badge bg-info" style="text-decoration:none;" href="/sgd.campania.descargar-campania/'+pCdCampania+'/'+pCdProcesoTecnico+'/'+response[b]['cd_variable']+'">Archivo de Campa&ntilde;a</a>');
                    }else{
                        vArrayValores.push('-');
                    }
                    vDatatable.row.add(vArrayValores).draw(false);
                }
                var vDivResultadoFinal=$('div[id="adicional1-panel-general"]');
                vDivResultadoFinal.html('');
                vDivResultadoFinal.append(fnArmarWidget(vContadorData,'Total','success'));
                swal.close();
                
            }).fail(function(a,b,c ){
                console.log(a,b,c);
            });

        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnBuscarCampaniasPorRemesa(){
    var vValorSelectRemesa=$('select[name="cd_remesa"] option:selected').val();
    if(vValorSelectRemesa){
        $.ajax({
            url:'/sgd.campania.listar-porremesas/'+vValorSelectRemesa,
            type:'GET'
        }).done(function(response){
            var vOptions='';
            var vDivParaColocarSelect=$('div[id="div-select"]');
            vDivParaColocarSelect.html('');
            if(response.length>0){
                for(var indice=0;indice<response.length;indice++){
                    vOptions+='<option value="'+response[indice]['value']+'">'+response[indice]['text']+'</option>';
                }
            }
            var vFormulario=
                '<div class="form-floating">'+
                '<select class="form-select" id="floatingSelect" name="cd_campania">'+
                    vOptions+
                '</select>'+
                '<label for="floatingSelect">C&oacute;digo de Campa&ntilde;a</label>'+
                '</div>'+
                '<center><p style="font-size:12px;color:red" id="cd_campania"></p></center>';
            vDivParaColocarSelect.append(vFormulario);
        })
    }
}

function fnDataPanelPorIntentos(pCdCampania,pCdProcesoTecnico){
    var vDatatable='';
    var vArmadoDatatable='';
    var vNombreDataTable='';
    var vDivParaAnexaDataTable=$('div[id="datatable1-panel-por-intentos"]');

    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            fnModalXs('<div class="spinner offset-md-5"></div><p>Cargando Tabla de Data &Oacute;ptima</p> ');
            $.ajax({
                url:'/sgd.campania.panel-por-intentos/'+pCdCampania+'/'+pCdProcesoTecnico,
                type:'GET',
            }).done(function(response){
                var vFuncionController='fnPanelPorIntentos';
                vDivParaAnexaDataTable.html('');
                vNombreDataTable='dt-panel-por-intentos';
                var vIndices=window[vFuncionController]()[1];
                vArmadoDatatable=fnArmarTablaDtTooltips(vFuncionController,vNombreDataTable);
                vDivParaAnexaDataTable.append('<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Panel por intentos de contacto de la Campa&ntilde;a</b></li>'+'<hr>'+vArmadoDatatable);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,10));
                var vContadorData=0;
                var vContadorContacto0=0;
                var vContadorContacto1=0;
                var vContadorContacto2=0;
                var vContadorContacto3=0;
                var vContadorContacto4=0;
                for(var b=0;b<response.length;b++){
                    var vCantidadRegistros0=parseInt(response[b]['ca_registros_int_0']);
                    var vCantidadRegistros1=parseInt(response[b]['ca_registros_int_1']);
                    var vCantidadRegistros2=parseInt(response[b]['ca_registros_int_2']);
                    var vCantidadRegistros3=parseInt(response[b]['ca_registros_int_3']);
                    var vCantidadRegistros4=parseInt(response[b]['ca_registros_int_4']);
                    vContadorContacto0+=vCantidadRegistros0;
                    vContadorContacto1+=vCantidadRegistros1;
                    vContadorContacto2+=vCantidadRegistros2;
                    vContadorContacto3+=vCantidadRegistros3;
                    vContadorContacto4+=vCantidadRegistros4;
                    vContadorData+=vCantidadRegistros0+vCantidadRegistros1+vCantidadRegistros2+vCantidadRegistros3+vCantidadRegistros4;
                    var vArrayValores=[];
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                    vArrayValores.push(
                        '<a class="badge bg-info" style="text-decoration:none;" onclick="fnDescargarCSV('+pCdCampania+','+response[b]['tx_variable']+',\''+response[b]['cd_variable']+'\')" >Archivo de Campa&ntilde;a</a>');
                    
                    vDatatable.row.add(vArrayValores).draw(false);
                }
                vDatatable.row.add(['Total Data',vContadorContacto0,vContadorContacto1,vContadorContacto2,vContadorContacto3,vContadorContacto4])
                .draw(false);;
                var vDivResultadoFinal=$('div[id="adicional1-panel-por-intentos"]');
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
function fnBuscarCampania(){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            var vOptionSelected=$('select[name="cd_campania"] option:selected').val();
            var vOptionRemesa=$('select[name="cd_remesa"] option:selected').val();
            if(vOptionSelected){
                var vSeparacionStr=vOptionSelected.split('-');
                $.ajax({
                    url:'/sgd.campania.detalle/'+vSeparacionStr[0],
                    type:'GET'
                }).done(function(response){
                    fnModalXs('<div class="spinner offset-md-5"></div><p>Cargando data.</p> ');
                    var vDivDetalleRemesa=$('div[id="detalle-campania"]');
                    vDivDetalleRemesa.html('');
                    var vBotonCierre='';
                    console.log(response);
                    if(response[0]['st_campania']==1){
                        vBotonCierre=
                        '<div class="col-md-6" style="font-size:14px; ">'+

                            '<li style="padding-left:10px;"><b>Cierre de Contacto:</b> '+
                                '<a class="badge bg-dark col-md-3" style="text-decoration:none;" onclick="fnCerrarContacto('+vSeparacionStr[0]+','+vSeparacionStr[1]+','+response[0]['nu_consecutivo']+')">Cerrar Contacto</a>'+
                            '</li>'+
                    
                        '</div>'+
                        '<div class="col-md-6" style="font-size:14px; ">'+

                        '<li style="padding-left:10px;"><b>Cierre de Campa&ntilde;a:</b> '+
                                '<a class="badge bg-dark col-md-3" style="text-decoration:none;" onclick="fnCerrarCampania('+vSeparacionStr[0]+','+vSeparacionStr[1]+')">Cerrar Campa&ntilde;a</a>'+
                            '</li>'+

                        '</div>'+
                        '<div class="col-md-6" style="font-size:14px; ">'+

                        '<li style="padding-left:10px;"><b>Gestion Campan&ntilde;a :</b> '+
                                '<a class="badge bg-dark col-md-3" style="text-decoration:none;" onclick="fnDescargarExcelDetalleCampania('+vSeparacionStr[0]+')">Detalle Campa&ntilde;a</a>'+
                            '</li>'+

                        '</div> <br>'+
                        '<hr>'+
                        '<div class="col-md-12">'+
                            '<center>'+
                            '<button class="btn btn-sm btn-dark" onclick="fnRenovarPaneles('+vSeparacionStr[0]+','+vSeparacionStr[1]+','+vOptionRemesa+')" type="button">'+
                              '<svg class="icon me-2">'+
                                '<use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-contrast"></use>'+
                              '</svg>Reiniciar Tableros'+
                            '</button>'+
                            '</center>'+
                        '</div>'

                        ;
                    }
                    vDivDetalleRemesa.append(fnArmarTarjetaConTitulos(response)+
                        vBotonCierre);
                    swal.close();
                    fnDataPanelGeneral(vSeparacionStr[0],vSeparacionStr[1]);
                    fnDataPanelPorIntentos(vSeparacionStr[0],vSeparacionStr[1]);
                    $('select[name="cd_campania"]').val(vOptionSelected);
                    //
                    var vPanelRemesa=$('div[id="panel-campania"]');
                    var vTitulo1=$('div[id="1"]');
                    var vTitulo2=$('div[id="2"]');
                    var vBodyAcordion=$('div[id="col-acordion-panel-general"]');
                    var vButtonAcordion=$('button[id="btn-acordion-panel-general"]');
                    vButtonAcordion.attr('aria-expanded','true');
                    vButtonAcordion.removeClass('collapsed');
                    vBodyAcordion.addClass('show');
                    vPanelRemesa.css('display','block');
                    vTitulo1.css('display','block');
                    vTitulo2.css('display','block');
                    $('select[name="cd_remesa"]').val(vOptionRemesa);
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

function fnCerrarCampania(pCdCampania,pCdProcesoTecnico){
    var vMensaje='Importante|Est&aacute; por ejecutar el <b>Cierre de campa&ntilde;a</b>, si lo hace dar&aacute; por terminada la campa&ntilde;a'
	var vArrayResumen=[];
	vArrayResumen.push(vMensaje);
    
    fnModalXsParaCarga(fnResumenCarga(vArrayResumen,'Cierre de Campa&ntilde;a')+'<p>¿Desea realizar el cierre de la campa&ntilde;a?<p>')
    .then((response) =>{
        if(response.isConfirmed){
            $.ajax({
                url:'/sgd.sesion.validar/',
                type:'GET',
            }).done(function(response){
                if(response.length>2){
                    fnModalXs('<div class="spinner offset-md-5"></div><p>Cargando Proceso</p> ');
                    $.ajax({
                        url:'/sgd.campania.cerrar/'+pCdCampania+'/'+pCdProcesoTecnico,
                        type:'GET',
                    }).done(function(response){
                        if(response==1){
                            fnModalXsCheck();
                            setTimeout(function(){
                                window.location.replace('/sgd.campania.resumen');
                            },2000);
                            swal.close();
                        }
                    });
                }else{
                    fnModalSesion();
                    setTimeout(function(){
                        fnBuscarCampania()
                        window.location.replace('/sgd.inicio');
                    },2500);
                    

                }
            });
        }
    });
}

function fnCerrarContacto(pCdCampania,pCdProcesoTecnico,pNumeroContacto){
    // 
    var vMensaje='Importante|Est&aacute; por ejecutar el <b>Cierre de Contacto</b>, Por consiguiente los datos que estan sin gestionar pasaran a una estatus sin contacto telef&oaacute;nico.'
	var vArrayResumen=[];
	vArrayResumen.push(vMensaje);
    fnModalXsParaCarga(fnResumenCarga(vArrayResumen,'Cierre de Contacto')+'<p>¿Desea realizar el cierre del <b>contacto de la campa&ntilde;a # '+pNumeroContacto+' ?</b><p>')
    .then((response) =>{
        if(response.isConfirmed){
            $.ajax({
                url:'/sgd.sesion.validar/',
                type:'GET',
            }).done(function(response){
                fnModalXs('<div class="spinner offset-md-5"></div><p>Cargando Proceso</p> ');
                if(response.length>2){
                    $.ajax({
                        url:'/sgd.campania.cerrar-contacto/'+pCdCampania+'/'+pCdProcesoTecnico+'/'+pNumeroContacto,
                        type:'GET',
                    }).done(function(response){
                        if(response==1){
                            swal.close();
                            fnModalXsCheck();
                            setTimeout(function(){
                                window.location.replace('/sgd.campania.resumen');
                            },2000);
                            
                        }
                    }).fail(function(a,b,c){
                        console.log(a,b,c);
                    });
                }else{
                    fnModalSesion();
                    setTimeout(function(){
                        fnBuscarCampania()
                        window.location.replace('/sgd.inicio');
                    },2500);
                    

                }
            }).fail(function(a,b,c){
                console.log(a,b,c);
            });
        }
    });
    
}
function fnDescargarExcelDetalleCampania(pCdRemesa){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            window.location.replace(vServer+'sgd.reportes-xlsx/JRDETALLECAMPANIA/CD_CAMPANIA-'+pCdRemesa);
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnRenovarPaneles(vCdCampania,vCdProceso,vCdRemesa){
    console.log(vCdCampania);
    fnDataPanelGeneral(vCdCampania,vCdProceso);
    fnDataPanelPorIntentos(vCdCampania,vCdProceso);
    $('select[name="cd_campania"]').val(vCdCampania+'-'+vCdProceso);
    $('select[name="cd_remesa"]').val(vCdRemesa);
    //
    var vPanelRemesa=$('div[id="panel-campania"]');
    var vTitulo1=$('div[id="1"]');
    var vTitulo2=$('div[id="2"]');
    var vBodyAcordion=$('div[id="col-acordion-panel-general"]');
    var vButtonAcordion=$('button[id="btn-acordion-panel-general"]');
    vButtonAcordion.attr('aria-expanded','true');
    vButtonAcordion.removeClass('collapsed');
    vBodyAcordion.addClass('show');
    vPanelRemesa.css('display','block');
    vTitulo1.css('display','block');
    vTitulo2.css('display','block');
    
}