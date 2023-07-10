
/**
 *  Parametrizacion de DataTables;
 */ 
function fnConfiguracionDataTable(pInputBusqueda,pInformacionRegistros,pCantidadFilas){
    var vDatatable={
        "lengthChange": pInformacionRegistros,
        "bInfo": false,
        "searching":pInputBusqueda,
        "language": {
          "emptyTable": "No existen registros para mostrar",
          "search":"Filtar por palabra:",
          "paginate": {
              "previous": "Anterior",
              
              "next":"Siguiente"
            }
        },
        "bAutoWidth": false,
        "ordering": false,
        "pageLength": pCantidadFilas,
        "columnDefs":[
            {targets: '_all', className: 'dt-head-center',className: 'dt-body-center'}
        ]
    };
    return vDatatable;
}

/**
 * Funcion para armar Table con un objeto
*/
function fnArmarTablaDt(pNombreFuncionController,pIdDataTable){
	var vCabceraDt='';
    vIndiceCabeceraDt=window[pNombreFuncionController]()[0];
	for(var indice=0;indice<vIndiceCabeceraDt.length;indice++){
		vCabceraDt+='<th scope="col">'+vIndiceCabeceraDt[indice]+'</th>';
	}
	var vTabla='<div class="table-responsive"><div class="table"><table id="'+pIdDataTable+'"class="table table-striped">'+
	    '<thead>'+
	        '<tr>'+
	        vCabceraDt+
	        '</tr>'+
	    '</thead>'+
		'</table></div></div>';
	return vTabla;
}
/** 
 * Funcion para armar Table de toolstips con un objeto
*/
function fnArmarTablaDtTooltips(pNombreFuncionController,pIdDataTable){
	var vCabceraDt='';
    vIndiceCabeceraDt=window[pNombreFuncionController]()[0];
    
	for(var indice=0;indice<vIndiceCabeceraDt.length;indice++){
        var vValorDeCabecera=(vIndiceCabeceraDt[indice]).split('|');
        //console.log(vValorDeCabecera);
		vCabceraDt+='<th scope="col" style="tooltip-nw">'+
            '<div class="tooltip-nw">'+
                vValorDeCabecera[0]+
                '<span class="tooltiptext">'+vValorDeCabecera[1]+'</span>'+
            '</div>'+
        '</th>';
	}
	var vTabla='<div class="table-responsive"><div class="table"><table id="'+pIdDataTable+'"class="table table-striped">'+
	    '<thead>'+
	        '<tr>'+
	        vCabceraDt+
	        '</tr>'+
	    '</thead>'+
		'</table></div></div>';
	return vTabla;
}

/**
 * Construir los inputs del formulario
 */
 function fnArmarForm(pIndice){
    var vFuncionController=$('input[name="funcionController'+pIndice+'"]').val();
    var vNombreController=$('input[name="nombreController'+pIndice+'"]').val();
    var vToken=$('input[name="_token"]').val();
    var vInputs=window[vFuncionController+'Forms']();
    var vForm='';
    var vInputsParametrizados='';
    for(var indice=0;indice<vInputs.length;indice++){
        var vInputIndice=(vInputs[indice]).split('|');

        if(vInputIndice[1]=='input'){
            vInputsParametrizados+=
            '<div class="col-md-'+vInputIndice[4]+'">'+
                '<div class="form-floating mb-3">'+
                    '<input type="'+vInputIndice[1]+'" class="form-control" name="'+vInputIndice[0]+'" id="floatingInput" placeholder="name@example.com">'+
                    '<label for="floatingInput">'+vInputIndice[3]+'</label>'+
                '</div>'+
                '<center><p style="font-size:12px;color:red" id="'+vInputIndice[0]+'"></p></center>'+
            '</div>';
        }
        if(vInputIndice[1]=='select'){
            if(vInputIndice[2]=='estatus'){
                vInputsParametrizados+=
                '<div class="col-md-'+vInputIndice[4]+'">'+
                        '<div class="form-floating">'+
                        '<select class="form-select" id="floatingSelect" name="'+vInputIndice[0]+'">'+
                            '<option value="1">Habilitado</option>'+
                            '<option value="0">In Habilitado</option>'+
                        '</select>'+
                        '<label for="floatingSelect">'+vInputIndice[3]+'</label>'+
                        '</div>'+
                        '<center><p style="font-size:12px;color:red" id="'+vInputIndice[0]+'"></p></center>'+
                    '</div>';
            }
            
            if(vInputIndice[2]=='d'){
                vInputsParametrizados+=
                '<div class="col-md-'+vInputIndice[4]+'">'+
                    '<div class="form-group">'+
                        '<label id="cd_contrato">'+vInputIndice[3]+'</label>'+
                        '<select class="form-control" name="'+vInputIndice[0]+'">'+
                            '<option value="V">Venezolano</option>'+
                            '<option value="E">Extranjero</option>'+
                            '<option value="J">Jur&iacute;dico</option>'+
                            '<option value="G">Gubernamental</option>'+
                        '</select>'+
                        '<center><p style="font-size:12px;color:red" id="'+vInputIndice[0]+'"></p></center>'+
                    '</div>'+
                '</div>';
            }
            if(vInputIndice[2]=='confirmacion'){
                vInputsParametrizados+=
                '<div class="col-md-'+vInputIndice[4]+'">'+
                        '<div class="form-floating">'+
                        '<select class="form-select" id="floatingSelect" name="'+vInputIndice[0]+'">'+
                            '<option value="1">Si</option>'+
                            '<option value="0">No</option>'+
                        '</select>'+
                        '<label for="floatingSelect">'+vInputIndice[3]+'</label>'+
                        '</div>'+
                        '<center><p style="font-size:12px;color:red" id="'+vInputIndice[0]+'"></p></center>'+
                    '</div>';
            }
        }
    }
    vInputsParametrizados+='<input type="hidden" name="_token_md" value="'+vToken+'">'+
    '<input type="hidden" name="nombreController_cd" value="'+vNombreController+'">'+
        '<div id="forms-ajax"></div>';
    vForm+=
        '<form name="formulario-agregar'+pIndice+'" onsubmit="return false;">'+
            '<div class="row">'+
                vInputsParametrizados+
                '<center>'+
                    '<br><button class="btn btn-dark" id="btn-confirmacion" onclick="fnBotonesConfirmacion('+pIndice+')" >Generar Operación</button></center>'+
                    '<div id="div-confirmacion"></div><br>'+
                '<center><div class="spinner" id="spinner" style="display:none;"></div></center>'+
            '</div>'+
        '</form>';
    return vForm;
}
/**
 * Armar Formularios para la actualizacion
 */
 function fnArmarFormUpdAjax(pValor,pIndice){
    var vNombreController=$('input[name="nombreController'+pIndice+'"]').val();
    var vFuncionController=$('input[name="funcionController'+pIndice+'"]').val();
    console.log(vFuncionController+'FormsUpdate');
    var vInputs=window[vFuncionController+'FormsUpdate']();
   
    var vToken=$('input[name="_token"]').val();
    $.ajax({
        url:'/sgd.listar.porId/'+vNombreController+'/'+pValor,
        type:'GET',
    }).done(function(response){
        vForm='';
        console.log(response);
        vInputsParametrizados='';
        for(var indice=0;indice<vInputs.length;indice++){
            var vInputIndice=(vInputs[indice]).split('|');
            for(var indice2=0;indice2<response.length;indice2++){
                if(vInputIndice[1]=='input'){
                    if(vInputIndice[2]=='hidden'){
                        vInputsParametrizados+='<input type="'+vInputIndice[2]+'" value="'+response[indice2][vInputIndice[0]]+'" class="form-control" name="'+vInputIndice[0]+'" id="floatingInput" placeholder="name@example.com">';
                    }else{
                        vInputsParametrizados+=
                        '<div class="col-md-'+vInputIndice[4]+'">'+
                            '<div class="form-floating mb-3">'+
                                '<input type="'+vInputIndice[2]+'" value="'+response[indice2][vInputIndice[0]]+'" class="form-control" name="'+vInputIndice[0]+'" id="floatingInput" placeholder="name@example.com">'+
                                '<label for="floatingInput">'+vInputIndice[3]+'</label>'+
                            '</div>'+
                            '<center><p style="font-size:12px;color:red" id="'+vInputIndice[0]+'"></p></center>'+
                        '</div>';
                    }
                    
                }
                
                if(vInputIndice[1]=='select'){
                    if(vInputIndice[2]=='estatus'){
                        var options='';
                        if(response[indice2][vInputIndice[0]]==1){
                            options='<option value="1" selected >Habilitado</option>'+
                                    '<option value="0">In Habilitado</option>';
                        }else{
                            options='<option value="1"  >Habilitado</option>'+
                                    '<option value="0" selected >In Habilitado</option>';
                        }
                        vInputsParametrizados+=
                        '<div class="col-md-'+vInputIndice[4]+'">'+
                                '<div class="form-floating">'+
                                '<select class="form-select" id="floatingSelect" name="'+vInputIndice[0]+'">'+
                                    options+
                                '</select>'+
                                '<label for="floatingSelect">'+vInputIndice[3]+'</label>'+
                                '</div>'+
                                '<center><p style="font-size:12px;color:red" id="'+vInputIndice[0]+'"></p></center>'+
                            '</div>';
                    }
                    if(vInputIndice[2]=='confirmacion'){
                        var options='';
                        if(response[indice2][vInputIndice[0]]==1){
                            options='<option value="1" selected >Si</option>'+
                                    '<option value="0">In No</option>';
                        }else{
                            options='<option value="1"  >Si</option>'+
                                    '<option value="0" selected >No</option>';
                        }
                        vInputsParametrizados+=
                        '<div class="col-md-'+vInputIndice[4]+'">'+
                                '<div class="form-floating">'+
                                '<select class="form-select" id="floatingSelect" name="'+vInputIndice[0]+'">'+
                                    options+
                                '</select>'+
                                '<label for="floatingSelect">'+vInputIndice[3]+'</label>'+
                                '</div>'+
                                '<center><p style="font-size:12px;color:red" id="'+vInputIndice[0]+'"></p></center>'+
                            '</div>';
                    }
                }
            }
        }
        vInputsParametrizados+='<input type="hidden" name="_token_md" value="'+vToken+'">'+
        '<input type="hidden" name="nombreController_cd" value="'+vNombreController+'">';
        vForm+=
            '<form name="formulario-update'+pIndice+'" onsubmit="return false;">'+
                '<div class="row">'+
                    vInputsParametrizados+
                    '<div id="form-ajax-upd-id"></div>'+
                    '<center>'+
                        '<br><button class="btn btn-dark" id="btn-confirmacion" onclick="fnBotonesConfirmacionUPD('+pIndice+')" >Generar Operación</button></center>'+
                        '<div id="div-confirmacion"></div><br>'+
                    '<center><div class="spinner" id="spinner" style="display:none;"></div></center>'+
                '</div>'+
            '</form>';
        var vDivForm=$('div[id="forms-ajax-upd"]');
        vDivForm.html('');
        vDivForm.append(vForm);
    }).fail(function(a,b,c){
        console.log(a,b,c);
    });
    return '';
}

/**
 * Construir formularios con data desde server vía ajax
 */
 function fnArmarSelectsPorAjax(pIndice){
    var vFuncionController=$('input[name="funcionController'+pIndice+'"]').val();
    var vValoresForm=window[vFuncionController+'Forms']();
    var vInputsParametrizados='';
    var vDivSelectsAjax=$('div[id="forms-ajax"]');
    vDivSelectsAjax.html('');
    vDivSelectsAjax
    for(var indice=0;indice<vValoresForm.length;indice++){
        var vValoresSelect=vValoresForm[indice].split('|');
        for(indice1=0;indice1<vValoresSelect.length;indice1++){              
            var vLinkSelect=vValoresSelect[indice1].split(':');
            if(vLinkSelect.length>1){
                $.ajax({
                    url:'/sgd.listar.select/'+vLinkSelect[1],
                    type:'GET'
                }).done(function(response){
                    console.log();
                    var vOptions='';
                    for(var indice2=0;indice2<response.length;indice2++){
                        vOptions+='<option value="'+response[indice2]['value']+'">'+
                            response[indice2]['text']+
                        '</option>';
                        if((indice2+1)==response.length){
                            vInputsParametrizados=
                            '<div class="col-md-'+response[indice2]['col']+'">'+
                                '<div class="form-floating">'+
                                '<select class="form-select" id="floatingSelect" name="'+response[indice2]['name']+'">'+
                                vOptions+
                                '</select>'+
                                '<label for="floatingSelect">'+response[indice2]['title']+'</label>'+
                                '</div>'+
                                '<center><p style="font-size:12px;color:red" id="'+response[indice2]['name']+'"></p></center>'+
                            '</div>';

                        }
                        
                    }
                    vDivSelectsAjax.append(vInputsParametrizados);

                });
            } 
        }
         
    } 
}
/**
 * 
 *
 */
 function fnArmarSelectsPorAjaxPorId(pIndice,pValor){
    var vFuncionController=$('input[name="funcionController'+pIndice+'"]').val();
    var vValoresForm=window[vFuncionController+'FormsUpdate']();
    var vInputsParametrizados='';
    var vAcumulador=0;
    for(var indice=0;indice<vValoresForm.length;indice++){
        var vValoresSelect=vValoresForm[indice].split('|');
        for(indice1=0;indice1<vValoresSelect.length;indice1++){              
            var vLinkSelect=vValoresSelect[indice1].split(':');

            if(vLinkSelect.length>1){
                
                $.ajax({
                    url:'/sgd.listar.select/'+vLinkSelect[1],
                    type:'GET'
                }).done(function(response){
                    var vDivSelectsAjax=$('div[id="form-ajax-upd-id"]');
                    vDivSelectsAjax.html('');
                    var vOptions='';
                    var vInputHidden=$('input[name="'+pValor+response[0]['name']+'"]').val();
                    for(var indice2=0;indice2<response.length;indice2++){
                        if(response[indice2]['value']==vInputHidden){
                            vOptions+='<option value="'+response[indice2]['value']+'" selected >'+
                                response[indice2]['text']+
                            '</option>';
                        }else{
                            vOptions+='<option value="'+response[indice2]['value']+'">'+
                                response[indice2]['text']+
                            '</option>';
                        }
                        if((indice2+1)==response.length){
                            vInputsParametrizados+=
                            '<div class="col-md-'+response[indice2]['col']+'">'+
                                '<div class="form-floating">'+
                                '<select class="form-select" id="floatingSelect" name="'+response[indice2]['name']+'">'+
                                vOptions+
                                '</select>'+
                                '<label for="floatingSelect">'+response[indice2]['title']+'</label>'+
                                '</div>'+
                                '<center><p style="font-size:12px;color:red" id="'+response[indice2]['name']+'"></p></center>'+
                            '</div>';

                        }
                        
                    }
                    vDivSelectsAjax.append('<div class="row">'+vInputsParametrizados+'</div>');

                });
            } 
        }
    } 
}

/**
 * Modal parametrizado
 */
function fnModal(pHtml){
   var vRetorno=Swal.fire({
        position: 'top',
        title: '',
        html: pHtml,
        showDenyButton: true,
        showConfirmButton: false,
        denyButtonText: 'Volver',
        customClass:'swal-xl',
    });
    return vRetorno;
}

function fnModalXs(pHtml){
    var vRetorno=Swal.fire({
         title: 'Informaci&oacute;n',
         html: pHtml,
         showDenyButton: false,
         showConfirmButton: false,
         customClass:'swal-xs',
     });
     return vRetorno;
 }

 

 function fnModalXsParaCarga(pHtml){
    var vRetorno=Swal.fire({
         title: 'Informaci&oacute;n',
         html: pHtml,
         showDenyButton: true,
         showConfirmButton: true,
         textConfirmButton:'Cargar',
         textDenyButton:'Volver',
         customClass:'swal-xs',
     });
     return vRetorno;
 }
 
 function fnModalMdParaCarga(pHtml){
    var vRetorno=Swal.fire({
        position: 'top',
         title: 'Informaci&oacute;n',
         html: pHtml,
         showDenyButton: true,
         showConfirmButton: true,
         textConfirmButton:'Cargar',
         textDenyButton:'Volver',
         customClass:'swal-xl',
     });
     return vRetorno;
 }
  function fnModalMdParaCarga(pHtml){
    var vRetorno=Swal.fire({
        position: 'top',
         title: 'Informaci&oacute;n',
         html: pHtml,
         showDenyButton: true,
         showConfirmButton: true,
         textConfirmButton:'Cargar',
         textDenyButton:'Volver',
         customClass:'swal-xxl',
     });
     return vRetorno;
 }

 function fnModalXsCentrado(pHtml){
    var vRetorno=Swal.fire({
        position: 'top',
        html: pHtml,
        showDenyButton: true,
        showConfirmButton: true,
        textConfirmButton:'Generar',
        textDenyButton:'Generar',
        customClass:'swal-xs',
     });
     return vRetorno;
 }

 function fnModalSesion(){
    var vRetorno=Swal.fire({
        position: 'top',
        title:'Su sesi&oacute;n ha acabado',
        icon:'error',
        text:'Será redigido al inicio.',
        showDenyButton: false,
        showConfirmButton: true,
        customClass:'swal-xs',
     });
     return vRetorno;
 }

function fnModalXsCheck(){
    var vRetorno=Swal.fire({
         title: 'Informaci&oacute;n',
         icon:'success',
         text:'Se ha realizado el registro con éxito.',
         showConfirmButton: false,
         customClass:'swal-xs',
     });
     return vRetorno;
}
function fnModalCarga(){
    var vRetorno=Swal.fire({
         title: 'Cargando Operaci&oacute;n',
         text:'',
         showConfirmButton: false,
         customClass:'swal-xs',
     });
     return vRetorno;
}

/*
 *  Botones para confirmacion Modal
 */
function fnBotonesConfirmacion(pIndice){
    var vDivConfirmacion=$('div[id="div-confirmacion"]');
    vDivConfirmacion.html('');
    var vBotonOperacion=$('button[id="btn-confirmacion"]');
    vBotonOperacion.css('display','none');
    var vHtml='';
    vHtml=
    '<div class="col-md-12"> ¿Est&aacute seguro de realizar el registro?</div><br>'+
    '<div class="col-md-4 offset-md-4"> <button class="btn btn-dark" onclick="fnAgregar('+pIndice+')">Si </button> <button class="btn btn-dark" onclick="fnBorrarConformacion()">No</button> </div>';
    vDivConfirmacion.append(vHtml);
 }
 function fnBotonesConfirmacionUPD(pIndice){
    var vDivConfirmacion=$('div[id="div-confirmacion"]');
    vDivConfirmacion.html('');
    var vBotonOperacion=$('button[id="btn-confirmacion"]');
    vBotonOperacion.css('display','none');
    var vHtml='';
    vHtml=
    '<div class="col-md-12"> ¿Est&aacute seguro de realizar el registro?</div><br>'+
    '<div class="col-md-4 offset-md-4"> <button class="btn btn-dark" onclick="fnActualizar('+pIndice+')">Si </button> <button class="btn btn-dark" onclick="fnBorrarConformacion()">No</button> </div>';
    vDivConfirmacion.append(vHtml);
 }
function fnBorrarConformacion(){
    var vDivConfirmacion=$('div[id="div-confirmacion"]');
    vDivConfirmacion.html('');
    var vBotonOperacion=$('button[id="btn-confirmacion"]');
    vBotonOperacion.css('display','block');
 }

/**
*   Barra de progreso
*/

function fnBarraProgeso(pCdProcentaje){
    var vHtml=
        '<div class="progress">'+
            '<div class="progress-bar progress-bar-striped bg-success"'+
            'role="progressbar" style="width:'+pCdProcentaje+'%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>'+
        '</div>';
        return vHtml;
}

/**
Validar si un formulario esta vacio en la carga de datos
*/
function fnValidar(pArray){
    var vContadorErrores=0;
    var vDiv='';
    for(var indice=0;indice<pArray.length;indice++){
            if(pArray[indice]['value']){
                vDiv=$('p[id="'+pArray[indice]['name']+'"]');
                vDiv.html('');
            }else{
                vDiv=$('p[id="'+pArray[indice]['name']+'"]');
                vDiv.html('');
                vDiv.append('El campo est&aacute; vac&iacute;o');
                vContadorErrores=vContadorErrores+1;
            }

    }
    return vContadorErrores;
}

/**
* Resumen de carga de Formulario
*/
function fnResumenCarga(pArregloResumen,pTitulo){
    var vHtml='<div class="list-group">';
    var vCabeceraGrupo=
        '<a class="list-group-item list-group-item-action flex-column align-items-start active" >'+
            '<div class="d-flex w-100 justify-content-between">'+
            '<h6 class="mb-1">'+pTitulo+'</h6><small>SGD</small>'+
            '</div>'+
        '</a>';
    
    var vCumuloGrupos='';
    for(var indice=0;indice<pArregloResumen.length;indice++){
        var vSeparacionStr=(pArregloResumen[indice]).split('|');
        var vGrupo=
        '<a class="list-group-item list-group-item-action flex-column align-items-start" >'+
            '<div class="d-flex w-100 justify-content-between">'+
            '<h6 class="mb-1">'+vSeparacionStr[0]+'</h6>'+
            '</div>'+
            '<p class="mb-1" style="text-align:left;">'+vSeparacionStr[1]+'</p>'+
        '</a>';
        vCumuloGrupos+=vGrupo;
    }
    vHtml+=
        vCabeceraGrupo+
        vCumuloGrupos+
        '</div><br>';
    return vHtml;
}

/**
* Armar detalle con List Groups Bootstrap
*/

function fnArmarTarjetaConListGroups(vListaArreglos){
    var vListGroup='';
    var vArreglo=vListaArreglos[0]['text'];
    console.log(vListaArreglos);
    var vSeparacionArreglo=vArreglo.split('|');
    for(var indice=0;indice<vSeparacionArreglo.length;indice++){
        var vSeparacionStr=(vSeparacionArreglo[indice]).split('^');;
        vListGroup+=
        '<div class="col-md-3">'+
        '<ul class="list-group" style="padding:7px; font-size:14px;">'+
            '<li class="list-group-item active" aria-current="true">'+vSeparacionStr[1]+'</li>'+
            '<li class="list-group-item">'+vSeparacionStr[0]+'</li>'+
        '</ul>'+
        '</div>';
    }
    return vListGroup;
}

/*
* funcion para armar detalle con Titulos y sub titulos
*/
function fnArmarTarjetaConTitulos(vListaArreglos){
    var vListGroup='';
    var vArreglo=vListaArreglos[0]['text'];
    console.log(vListaArreglos);
    var vSeparacionArreglo=vArreglo.split('|');
    for(var indice=0;indice<vSeparacionArreglo.length;indice++){
        var vSeparacionStr=(vSeparacionArreglo[indice]).split('^');;
        vListGroup+=
        '<div class="col-md-6" style="font-size:14px; ">'+
            '<li style="padding-left:10px;"><b>'+vSeparacionStr[1]+'</b>: '+vSeparacionStr[0]+'</li>'+
        '</div>';
    }
    return vListGroup;
}

/**
*
*/
function fnArmarWidget(vTotal,vTitulo,vColor){
    var vHtml='<div class="col-md-2 offset-md-9">'+
        '<div class="card-body p-3 d-flex align-items-center">'+
            '<div class="bg-'+vColor+' text-white p-3 me-3">'+
              '<svg class="icon icon-xl">'+
                '<use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-bell"></use>'+
              '</svg>'+
            '</div>'+
            '<div>'+
              '<div class="fs-6 fw-semibold text-'+vColor+'">'+vTotal+'</div>'+
              '<div class="text-medium-emphasis text-uppercase fw-semibold small">'+vTitulo+'</div>'+
            '</div>'+
        '</div>'+
        '</div>';
    return vHtml;
}

/**
* Function para armar select con division de registros
*/

function fnArmarFormularioDivisorDeRegistros(pCantidadRegistros,pId){
    var vSelect='';
    if((parseInt(pCantidadRegistros)>500)){
        vCantidadOptions=parseInt(pCantidadRegistros)/500;
        vOptions='';    
        for(var index=0;index<vCantidadOptions;index++){
            if(((index+1)*500)>parseInt(pCantidadRegistros)){}else{
                    vOptions+='<option value="'+((index+1)*500)+'">'+((index+1)*500)+'</option>';
            }
        }
        vOptions+='<option value="'+parseInt(pCantidadRegistros)+'">'+parseInt(pCantidadRegistros)+'</option>';
        vSelect=
        '<div class="col-md-12">'+
            '<div class="form-floating">'+
                '<select class="form-select" id="floatingSelect" name="'+pId+'">'+
                    vOptions+
                '</select>'+
                '<label for="floatingSelect">Cantidad de Registros</label>'+
            '</div>'+
            '<center><p style="font-size:12px;color:red" id="'+pId+'"></p></center>'+
        '</div>';
    }else{
        vSelect=
            '<div class="col-md-12">'+
                '<div class="form-floating">'+
                    '<select class="form-select" id="floatingSelect" name="'+pId+'">'+
                    '<option value="'+pCantidadRegistros+'">'+pCantidadRegistros+'</option>'+
                    '</select>'+
                    '<label for="floatingSelect">Cantidad de Registros</label>'+
                '</div>'+
                '<center><p style="font-size:12px;color:red" id="'+pId+'"></p></center>'+
            '</div>';
    }
    return vSelect;        
}
/**
 * Construir formularios con data desde server vía ajax
 */
 function fnArmarSelectsPorAjaxCustom(pFuncion){
    var vValoresForm=window[pFuncion]();
    var vInputsParametrizados='';
    var vDivSelectsAjax=$('div[id="forms-ajax"]');
    vDivSelectsAjax.html('');
    for(var indice=0;indice<vValoresForm.length;indice++){
        var vValoresSelect=vValoresForm[indice].split('|');
        for(indice1=0;indice1<vValoresSelect.length;indice1++){              
            var vLinkSelect=vValoresSelect[indice1].split(':');
            if(vLinkSelect.length>1){
                $.ajax({
                    url:'/sgd.listar.select-custom/'+vLinkSelect[1],
                    type:'GET'
                }).done(function(response){
                    var vOptions='';
                    for(var indice2=0;indice2<response.length;indice2++){
                        vOptions+='<option value="'+response[indice2]['value']+'">'+
                            response[indice2]['text']+
                        '</option>';
                        if((indice2+1)==response.length){
                            vInputsParametrizados=
                            '<div class="col-md-'+response[indice2]['col']+'">'+
                                '<div class="form-floating">'+
                                '<select class="form-select" id="floatingSelect" name="'+response[indice2]['name']+'">'+
                                vOptions+
                                '</select>'+
                                '<label for="floatingSelect">'+response[indice2]['title']+'</label>'+
                                '</div>'+
                                '<center><p style="font-size:12px;color:red" id="'+response[indice2]['name']+'"></p></center>'+
                            '</div>';

                        }
                        
                    }
                    vDivSelectsAjax.append('<div class="row">'+vInputsParametrizados+'</div>');

                });
            } 
        }
         
    } 
}

/**
 * Funcion para mostrar Rangos de Edades en una tabla antes de insertar
 */
function fnTablaResumenDeCarga(vFormulario,VfuncionObjetos){
	//console.log(vFormulario);
	var vValores=window[VfuncionObjetos]();
	var vRetorno=
    '<div class="table-responsive text-nowrap">'+
        '<table class="table table-sm table-striped" id="dt_gestion" class="display" style="width:100%;font-size:14px;">'+
    		'<thead style="background-color: rgba(48, 60, 84, 0.88);color: #fff;" id="header">'+
        		'<tr>';
    var vCabecera='';
    for(var a=0;a<vValores.length;a++){
        vCabecera+='<th>'+vValores[a].split('|')[1]+'</th>';
    }
    vRetorno+=vCabecera+'</tr></thead>';
    
	if(vFormulario.length>0){
		var vContenido='<tbody>';
		var vFilas='';
		for(var indice=0;indice<vFormulario.length;indice++){
			vFilas+='<tr>';
			for(var indice2=0;indice2<vValores.length;indice2++){
				vValorInput=vFormulario[indice][vValores[indice2].split('|')[0]];
				vFilas+='<td>'+vValorInput+'</td>';
			}
			vFilas+='</tr>';
		}
	}
	vRetorno+=vContenido+vFilas+'</tbody></table></div>';
	return vRetorno;
}

/**
* Resumen de carga de Formulario expandido
*/
function fnResumenCargaEnTarjetas(pArregloResumen,pTitulo){
    var vHtml='<div class="row">';
    var vCumuloGrupos='';
    var vCumuloVariables='';
    var vCumuloTecnico='';
    var vCumuloAdicionales='';
    var vAdicionales=[];
    var vContador=0;
    for(var indice=0;indice<pArregloResumen.length;indice++){
        var vSeparacionStr=(pArregloResumen[indice]).split('|');
        var vGrupo='';
        var vTecnico='';
        
        var vVariablesTelefonicas = vSeparacionStr[2].includes("cd_variable");
        var vVariablesTecnicas = vSeparacionStr[2].substr(0,2).includes("co");
        var vVariablesAdicionales = vSeparacionStr[2].substr(0,2).includes("ad");
        console.log(vSeparacionStr[2]);
        if(vVariablesTelefonicas){
            vCumuloVariables+=
            '<div class="col-md-2">'+
                '<div class="card" style="margin:5px;">'+
                '<div class="card-header">'+
                    vSeparacionStr[0]+
                '</div>'+
                '<ul class="list-group list-group-flush">'+
                '<li class="list-group-item">'+vSeparacionStr[1]+'</li>'+
                '</ul>'+
            '</div>'+
            '</div>';
        }else{
            if(vVariablesTecnicas){
                vTecnico+=
                '<div class="col-md-2">'+
                    '<div class="card" style="margin:5px;">'+
                    '<div class="card-header">'+
                        vSeparacionStr[0]+
                    '</div>'+
                    '<ul class="list-group list-group-flush">'+
                    '<li class="list-group-item">'+vSeparacionStr[1]+'</li>'+
                    '</ul>'+
                '</div>'+
                '</div>';
            }else{
                if(vVariablesAdicionales){  
                    vAdicionales.push(vSeparacionStr[1]);
                }else{
                    vGrupo+=
                    '<div class="col-md-2">'+
                        '<div class="card" style="margin:5px;">'+
                        '<div class="card-header">'+
                            vSeparacionStr[0]+
                        '</div>'+
                        '<ul class="list-group list-group-flush">'+
                        '<li class="list-group-item">'+vSeparacionStr[1]+'</li>'+
                        '</ul>'+
                    '</div>'+
                    '</div>'; 
                }
               
            }
        }
        vCumuloGrupos+=vGrupo;
        vCumuloTecnico+=vTecnico;
        
        
    }
    console.log(vAdicionales);
    var vCumuloAdicionales='';
    for(var indice2=0;indice2<vAdicionales.length;indice2++){
            if((indice2+1)%6==0){
                vCumuloAdicionales+=
                    '<tr>'+
                        '<td>'+vAdicionales[indice2-5]+'</td>'+
                        '<td>'+vAdicionales[indice2-4]+'</td>'+
                        '<td>'+vAdicionales[indice2-3]+'</td>'+
                        '<td>'+vAdicionales[indice2-2]+'</td>'+
                        '<td>'+vAdicionales[indice2-1]+'</td>'+
                        '<td>'+vAdicionales[indice2]+'</td>'+
                    '</tr>';
            }
    }
    vHtml+=
    '<div class="container-fluid">'+
        '<p style="font-size:14px;text-align:center;"><b>Datos Personales</b></p>'+
    '<hr></div>'+    
    vCumuloGrupos+
    '<div class="container-fluid">'+
        '<p style="font-size:14px;text-align:center;"><b>Variables de Contacto</b></p>'+
    '<hr></div>'+
    vCumuloVariables+
    '<div class="container-fluid">'+
        '<p style="font-size:14px;text-align:center;"><b>Variables T&eacute;nicas</b></p>'+
    '<hr></div>'+
    vCumuloTecnico+
    '<div class="container-fluid">'+
        '<p style="font-size:14px;text-align:center;"><b>Adicionales</b></p>'+
    '<hr></div>'+
    '<div class="container-fluid">'+
    '<table class="table table-bordered table-responsive">'+
        '<thead>'+
            '<th>Parentesco</th>'+
            '<th>Tipo Documento</th>'+
            '<th>N&uacute;mero de Documento</th>'+
            '<th>&Aacute;rea</th>'+
            '<th>Tel&eacute;fono</th>'+
            '<th>Fecha de nacimiento</th>'+
        '</thead>'+
        '<tbody>'+
            vCumuloAdicionales+
        '</tbody>'+
    '</table>'+
    '</div>';
    return vHtml;
}
function fnConstruirTpDocumentoAdicional(pIndice){
    var vSelect=
    '<div class="col-md-2">'+
        '<div class="form-floating">'+
            '<select class="form-select" id="floatingSelect" name="ad_tp_documento'+pIndice+'">'+
            '<option value="V">Venezolano</option>'+
            '<option value="E">Extranjero</option>'+
            '<option value="G">Gubernamental</option>'+
            '<option value="J">Jur&iacute;dico</option>'+
            '</select>'+
            '<label for="floatingSelect" id="ad_tp_documento'+pIndice+'">Tipo Documento</label>'+
        '</div>'+
        '<center><p style="font-size:12px;color:red" id="ad_tp_documento'+pIndice+'"></p></center>'+
    '</div>';
    return vSelect;
}
function fnConstruirInput(vNombre,vlabel,vTipo){
    var  vInput=
    '<div class="col-md-2">'+
        '<div class="form-floating mb-3">'+
            '<input type="'+vTipo+'" class="form-control" name="'+vNombre+'" placeholder="999999999">'+
            '<label for="floatingInput" id="'+vNombre+'">'+vlabel+'</label>'+
        '</div>'+
        '<center><p style="font-size:12px;color:red" id="'+vNombre+'"></p></center>'+
    '</div>';
    return vInput;
}
function fnConstruirNuAreaAdicional(pIndice){
    var vSelect=
   
    '<div class="col-md-2">'+
        '<div class="form-floating">'+
            '<select class="form-select" id="floatingSelect" name="ad_nu_area'+pIndice+'">'+
            '<option value="0"></option>'+
            '<option value="424">424</option>'+
            '<option value="414">414</option>'+
            '<option value="426">426</option>'+
            '<option value="412">412</option>'+
            '</select>'+
            '<label for="floatingSelect" id="ad_nu_area'+pIndice+'">Area Telefono</label>'+
        '</div>'+
        '<center><p style="font-size:12px;color:red" id="ad_nu_area'+pIndice+'"></p></center>'+
    '</div>';
    return vSelect;
}
function fnBuscarParentescoAdicional(pIndice){
    var vSelect=
   
    '<div class="col-md-2">'+
    '<div class="form-floating">'+
        '<select class="form-select" name="ad_cd_parentesco'+pIndice+'">'+
       '<option value="0"></option>'+
        '<option value="1">Titular</option>'+
        '<option value="2">Conyuge</option>'+
        '<option value="3">Hijo(a)</option>'+
        '<option value="4">Hermano(a)</option>'+
        '<option value="5">Hijastro(a)</option>'+
        '<option value="6">Padre</option>'+
        '<option value="7">Madre</option>'+
        '<option value="8">Suegro</option>'+
        '<option value="9">Suegra</option>'+
        '<option value="10">Abuelo(a)</option>'+
        '<option value="11">Nieto(a)</option>'+
        '<option value="12">Tio(a)</option>'+
        '<option value="13">Primo(a)</option>'+
        '<option value="14">Sobrino(a)</option>'+
        '<option value="17">Cuñado(a)</option>'+
        '<option value="18">Yerno(a)</option>'+
        '<option value="19">Nuera</option>'+
        '<option value="20">Amigo(a)</option>'+
        '<option value="21">Acreedor(a)</option>'+
        '<option value="22">Padre P.(Proporcional)</option>'+
        '<option value="23">Madre P.(Proporcional)</option>'+
        '<option value="30">Hijo(a)  Discapacitado(a)</option>'+
        '<option value="31">Madre (Adicional)</option>'+
        '<option value="32">Padre (Adicional)</option>'+
        '<option value="33">Padrastro</option>'+
        '<option value="35">A. (Adicional)</option>'+
        '<option value="37">Hijo(a) (Adicional)</option>'+
        '<option value="90">Herederos Legales</option>'+
        '</select>'+
        '<label for="floatingSelect" id="ad_cd_parentesco'+pIndice+'">Parentesco</label></div><center><p style="font-size:12px;color:red" id="ad_cd_parentesco'+pIndice+'"></p></center></div>';
    return vSelect;
}


/*function fnBuscarParentescoAdicional(){
    $.ajax({
        url:'/sgd.campania.buscar-parentesco/',
        type:'GET'
    }).done(function(response){
        if(response.length>0){
            var vDivAdicionales=$('div[id="div-formulario-parentesco"]');
            vDivAdicionales.html('');
            var vOptions='';
            for(var indice=0;indice<response.length;indice++){
                vOptions+='<option value="'+response[indice]['cd_parentesco']+'">'+response[indice]['de_parentesco']+'</option>';
            }
            var vSelectAdicionales=
            '<div class="col-md-12">'+
                '<div class="form-floating">'+
                    '<select class="form-select"  name="ad_cd_parentesco">'+
                    '<option value="0"></option>'+
                    vOptions+
                    '</select>'+
                    '<label for="floatingSelect" id="ad_cd_parentesco">Parentesco</label>'+
                '</div>'+
                '<center><p style="font-size:12px;color:red" id="ad_cd_parentesco"></p></center>'+
            '</div>';
            vDivAdicionales.append(vSelectAdicionales);
        }
    }).fail(function(a,b,c){
        console.log(a,b,c);
    })        
}*/
