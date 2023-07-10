function fnBuscarCliente(){
	var vValorSelect=$('input[name="nu_documento_aux"]').val();
	if(vValorSelect){
		setTimeout(() => {
			fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de Cliente.</p> ');
		}, 1000);
		window.location.replace('/sgd.campania.formulario-campania/'+vValorSelect);
	}else{
		setTimeout(() => {
			fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de Cliente.</p> ');
		}, 1000);
		window.location.replace('/sgd.campania.formulario-campania/$AL');
	}
}
function fnBuscarHijos(vNivel){
    var vValorSelect=$('select[name="cd_variable'+vNivel+'"] option:selected').val();
    var vSiguenteNivel=(parseInt(vNivel)+1 );

    fnLimpiarFormularios(vNivel);
    fnBuscarFormularioTecnico(vValorSelect);
    $.ajax({
        url:'/sgd.campania.buscar-variables-subniveles/'+vSiguenteNivel+'/'+vValorSelect,
        type:'GET'
    }).done(function(response){
        var vValorSelect=$('select[name="cd_variable'+vSiguenteNivel+'"]');
        var vDivSelect=$('div[id="cd_variable'+vSiguenteNivel+'"]');
        if(response.length>0){
            vValorSelect.html('');
            vDivSelect.css('display','block');
            var vOptions='<option value=""></option>';
            for(var indice=0;indice<response.length;indice++){
                vOptions+='<option value="'+response[indice]['value']+'">'+response[indice]['text']+'</option>';
            }
            vValorSelect.append(vOptions);
        }else{
            vValorSelect.html('');
            var vOptions='<option value=""></option>';
            vValorSelect.append(vOptions);
        }   
        

    })
    .fail(function(a,b,c){
        console.log(a,b,c);
    })
}

function fnBuscarFormularioTecnico(pCdVariable){
    $.ajax({
        url:'/sgd.campania.buscar-formulario-tecnico/'+pCdVariable,
        type:'GET'
    }).done(function(response){
        var vDivSelect=$('div[id="div-formulario-tecnico"]');
        if(response.length>0){
            vDivSelect.css('display','contents');
        } else{
            vDivSelect.css('display','none');
        }
    }).fail(function(a,b,c){
        console.log(a,b,c);
    });

}
function fnLimpiarFormularios(pNivel){
    console.log(pNivel);
    for(var indice=pNivel+1;indice<10;indice++){
        var vVariable=$('select[name="cd_variable'+indice+'"]');
        vVariable.html('');
        var vDivSelect=$('div[id="cd_variable'+indice+'"]');
        vDivSelect.css('display','none');
    }
    $('div[id="div-formulario-sumas"]').html('');
    $('div[id="div-formulario-adicionales"]').html('');
}
function fnCargaContacto(){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>0){
            var vArrayFormulario=[];
            var vFormulario=$('form[name="forms-campania"]').serializeArray();
            for(var indice00=0;indice00<vFormulario.length;indice00++){
                if(vFormulario[indice00]['value'] && vFormulario[indice00]['name'] ){
                    var vElementSelect=$('select[name="'+vFormulario[indice00]['name']+'"] option:selected');
                    var vValor='';
                    var vLabel=$('label[id="'+vFormulario[indice00]['name']+'"]').html();

                    if(vLabel){
                        if(vElementSelect.length>0){
                            if(vElementSelect.text()){
                                vValor=vElementSelect.text();
                                vArrayFormulario.push(vLabel+'|'+vValor+'|'+vFormulario[indice00]['name']);
                            }
                        }
                        var vElementInput=$('input[name="'+vFormulario[indice00]['name']+'"]');
                        if(vElementInput.length>0){
                            if(vElementInput.val()){
                                vValor=vElementInput.val();
                                vArrayFormulario.push(vLabel+'|'+vValor+'|'+vFormulario[indice00]['name']);
                            }
                            
                        }
                    }
                    
                }
                
            }
            fnModalMdParaCarga(fnResumenCargaEnTarjetas(vArrayFormulario,'Formulario Call Center'))
            .then((response) =>{
                if(response.isConfirmed){
                    
                    var vTokenLaravel=$('input[name="_token"]').val();
                    var vObjFormulario={};
                    for(var indice0=0;indice0<vFormulario.length;indice0++){
                        vObjFormulario[vFormulario[indice0].name]=vFormulario[indice0].value;
                    }
                    var vVariable0=$('select[name="cd_variable0"] option:selected').val();
                    var vDivVariable0=$('p[id="cd_variable0"]');
                    fnModalXs('<div class="spinner offset-md-5"></div><p>Cargado informacion</p>');
                    vDivVariable0.html('');
                    if(vVariable0){

                        $.ajax({
                            url:'/sgd.campania.actualizar-formulario-campania',
                            type:'POST',
                            cache:false,
                            headers: {'X-CSRF-TOKEN': vTokenLaravel},
                            data:vFormulario
                        }).done(function(response){

                            if(response==1){
                                fnModalXsCheck();
                                setTimeout(function(){
                                    window.location.replace('/sgd.campania.formulario-campania/$AL');
                                },2000);
                            }else{
                                swal.close();
                                //var vJsonResponse=JSON.parse(response);
                                var vKeysJsonResponse=Object.keys(response);
                                var vKeysFormulario=Object.keys(vObjFormulario);
                                for(var indice=0;indice<vKeysJsonResponse.length;indice++){
                                    var vEtiquetaError=$('p[id="'+vKeysJsonResponse[indice]+'"]');
                                    vEtiquetaError.html('');
                                    var vArrayErrores=response[vKeysJsonResponse[indice]];
                                    for(var indice1=0;indice1<vArrayErrores.length;indice1++){
                                        vEtiquetaError.append(vArrayErrores[indice1]);
                                    }
                                }
                                for(var indice2=0;indice2<vKeysFormulario.length;indice2++){
                                    $vContador=0;
                                    for(var indice3=0;indice3<vKeysJsonResponse.length;indice3++){
                                        if(vKeysFormulario[indice2]==vKeysJsonResponse[indice3]){
                                            $vContador+=1;
                                        }   
                                    }
                                    if($vContador==0){
                                        var vEtiquetaParaLimpiarError=$('p[id="'+vKeysFormulario[indice2]+'"]');
                                        vEtiquetaParaLimpiarError.html('');
                                    }
                                }
                            }
                        }).fail(function(a,b,c){
                            console.log(a,b,c);
                        });
                    }else{
                        swal.close();
                        vDivVariable0.html('');
                        vDivVariable0.append('La variable principal se debe llenar.');
                    }
                    
                }
            })
            
        }
    });
}
function fnBuscarSumasAseguradas(){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        
        if(response.length>2){
            var vGrupoFamiliar=$('select[name="co_grupo_familiar"] option:selected').val();
            var vCdCampania=$('input[name="cd_campania"]').val();
            
            if(vGrupoFamiliar){
                $.ajax({
                    url:'/sgd.campania.buscar-suma-asegurada/'+vGrupoFamiliar+'/'+vCdCampania,
                    type:'GET'
                }).done(function(response){
                    if(response.length>0){
                        var vDivAdicionales=$('div[id="div-formulario-adicionales"]');
                        var vDivSumasAseguradas=$('div[id="div-formulario-sumas"]');
                        vDivSumasAseguradas.html('');
                        var vOptions='';
                        for(var indice=0;indice<response.length;indice++){
                            vOptions+='<option value="'+response[indice]['value']+'">'+response[indice]['text']+'</option>';
                        }

                        var vSelectSumasAseguradas=
                        '<div class="form-floating">'+
                            '<select class="form-select" id="co_suma_asegurada" name="co_suma_asegurada">'+
                            '<option value=""></option>'+
                               vOptions+
                            '</select>'+
                            '<label for="co_suma_asegurada" id="co_suma_asegurada">Suma Asegurada</label>'+
                        '</div>';
                        vDivSumasAseguradas.append(vSelectSumasAseguradas);
                        fnBuscarAdicionales();
                    }
                }).fail(function(a,b,c){

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
function fnBuscarAdicionales(){

    $.ajax({
        url:'/sgd.campania.buscar-adicionales/',
        type:'GET'
    }).done(function(response){
        if(response.length>0){
            var vDivAdicionales=$('div[id="div-formulario-adicionales"]');
            vDivAdicionales.html('');
            var vOptions='';
            for(var indice=0;indice<response.length;indice++){
                vOptions+='<option value="'+response[indice]['value']+'">'+response[indice]['text']+'</option>';
            }

            var vSelectAdicionales=
            '<div class="form-floating">'+
                '<select class="form-select" id="co_adicionales" name="co_adicionales" onchange="fnMostrarFormularioAdicionales()">'+
                '<option value="0"></option>'+
                   vOptions+
                '</select>'+
                '<label for="co_adicionales" id="co_adicionales">Adicionales</label>'+
            '</div>';
            vDivAdicionales.append(vSelectAdicionales);
        }
    }).fail(function(a,b,c){
        console.log(a,b,c);
    })        
}

function fnMostrarFormularioAdicionales(){
    var vCantidadDeFormularios=$('select[name="co_adicionales"] option:selected').val();
    if(vCantidadDeFormularios){
        var vDivAdicionales=$('div[id="div-formulario-familiares"]');
        vDivAdicionales.html('');
        var vFormularios='';
        $('input[name="contador"]').val(0);
        for(var indice=0;indice<vCantidadDeFormularios;indice++){
            vFormularios+=fnBuscarParentescoAdicional(indice);
            vFormularios+=fnConstruirTpDocumentoAdicional(indice);
            vFormularios+=fnConstruirInput('ad_nu_documento'+indice,'N&uacute;mero de Documento','number');
            vFormularios+=fnConstruirNuAreaAdicional(indice);
            vFormularios+=fnConstruirInput('ad_nu_telefono'+indice,'N&uacute;mero de Tel&eacute;fono','number');
            vFormularios+=fnConstruirInput('ad_fe_nacimiento'+indice,'Fecha de Nacimiento','date');
        }
        vDivAdicionales.append('<div class="col-md-12"><li style="list-style: disclosure-closed;font-size:14px;padding-bottom: 15px;" ><b>Familiares Adicionales</b></li></div>'+
            '<hr>'+
            vFormularios);
       
    }
}

