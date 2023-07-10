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
                    url:'/sgd.campania.emision-detalle-proceso-campanias/'+vSeparacionStr[0]+'/'+vSeparacionStr[1],
                    type:'GET'
                }).done(function(response){
                    fnModalXs('<div class="spinner offset-md-5"></div><p>Cargando data.</p> ');
                    var vDivDetalleRemesa=$('div[id="detalle-campania"]');
                    vDivDetalleRemesa.html('');
                    var vBotonCierre='';

                    vBotonCierre=
                        '<div class="col-md-12">'+
                            '<center>'+
                            '<button class="btn btn-sm btn-dark" onclick="fnRenovarPaneles('+vSeparacionStr[0]+','+vSeparacionStr[1]+','+vOptionRemesa+')" type="button">'+
                              '<svg class="icon me-2">'+
                                '<use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-contrast"></use>'+
                              '</svg>Reiniciar Tableros'+
                            '</button>'+
                            '</center>'+
                        '</div>';
                    
                    vDivDetalleRemesa.append(fnArmarTarjetaConTitulos(response)+
                        vBotonCierre);
                    swal.close();
                    fnDataPanelGeneral(vSeparacionStr[1],vSeparacionStr[0]);
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
                url:'/sgd.campania.emision-panel-general/'+pCdProcesoTecnico+'/'+pCdCampania,
                type:'GET',
            }).done(function(response){
            	console.log(response);
                var vFuncionController='fnPanelCampaniaEmision';
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
                   
                    var vFases=
                    fnBotonesProcesosTecnicos(
                        response[b]['in_solicitud_seguros'],
                        response[b]['in_cuadro_poliza'],
                        response[b]['in_emision'],
                        response[b]['cd_proceso_campania'],
                        response[b]['ca_registros']);
                    vArrayFases=vFases.split('$');
                    vArrayValores.push(vArrayFases[0]);
                    vArrayValores.push(vArrayFases[1]);
                    vArrayValores.push(vArrayFases[2]);
                    var vNodo=vDatatable.row.add(vArrayValores).draw(false);
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
function fnBuscarCampaniasPorProceso(){
    var vValorSelectRemesa=$('select[name="cd_remesa"] option:selected').val();
    if(vValorSelectRemesa){
        $.ajax({
            url:'/sgd.campania.emision-listar-proceso-por-campanias/'+vValorSelectRemesa,
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

function fnBotonesProcesosTecnicos(pSolicitudSeguros,pCuadroPoliza,pEmisionMasiva,pCdProcesoTecnico,pCantidaRegistros){
    var vBotones='';
    var vBotonSS='<div class="badge bg-danger">Sol. Seguros</div>';
    var vBotonEM='<div class="badge bg-danger">Emisi&oacute;n</div>';
    var vBotonCD='<div class="badge bg-danger">Cuadro P&oacute;liza</div>';

    if(pSolicitudSeguros==0){vBotonSS='<a class="badge bg-warning" onclick="fnSolicitudSeguros('+pCdProcesoTecnico+','+pCantidaRegistros+')">Sol. Seguros</a>';}
    if(pSolicitudSeguros==1){vBotonSS='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',1,'+pSolicitudSeguros+')">Det. Solictud</a>';}
    if(pSolicitudSeguros==1 && pEmisionMasiva==0){vBotonEM='<a class="badge bg-warning" onclick="fnEmisionMasiva('+pCdProcesoTecnico+','+pCantidaRegistros+')">Emisi&oacute;n</a>';}
    if(pSolicitudSeguros==1 && (pEmisionMasiva==99 || pEmisionMasiva==1)){vBotonEM='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',2,'+pEmisionMasiva+')">Det. Emisi&oacute;n</a>';}
    if(pEmisionMasiva==1 && pCuadroPoliza==0){vBotonCD='<a class="badge bg-warning" onclick="fnEnvioCuadroPoliza('+pCdProcesoTecnico+','+pCantidaRegistros+')">Cuadro P&oacute;liza</a>';}
    if(pEmisionMasiva==1 && pCuadroPoliza==1){vBotonCD='<a class="badge bg-success" onclick="fnDetalleProceso('+pCdProcesoTecnico+','+pCantidaRegistros+',3,'+pCuadroPoliza+')">Det. Cuadro P&oacute;liza</a>';}
   
    vBotones=vBotonSS+'$'+vBotonEM+'$'+vBotonCD;
    return vBotones;
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
                        url:'/sgd.campania.emision.actualizar/'+pProcesoTecnico+'/1',
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
                            url:'/sgd.campania.emision.actualizar/'+pProcesoTecnico+'/2',
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
                        url:'/sgd.campania.emision.actualizar/'+pProcesoTecnico+'/3',
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