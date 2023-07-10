function fnBuscarCliente(){
	var vValorSelect=$('input[name="nu_documento"]').val();
	if(vValorSelect){
		setTimeout(() => {
			fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de Cliente.</p> ');
		}, 1000);
		window.location.replace('/sgd.proceso-tecnico.formulario-emision/'+vValorSelect);
	}else{
		setTimeout(() => {
			fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de Cliente.</p> ');
		}, 1000);
		window.location.replace('/sgd.proceso-tecnico.formulario-emision/$AL');
	}
}
function fnProcesarError(){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>0){
            fnModalXsParaCarga('<p>¿Desea realizar la carga?<p>')
            .then((response) =>{
                if(response.isConfirmed){
                    var vFormulario=$('form[name="forms-errores-emision"]').serializeArray();
                    var vTokenLaravel=$('input[name="_token"]').val();
                    var vObjFormulario={};
                    for(var indice0=0;indice0<vFormulario.length;indice0++){
                        vObjFormulario[vFormulario[indice0].name]=vFormulario[indice0].value;
                    }
                    var vSpinner=$('div[id="spinner"]');
                    vSpinner.css('display','block');
                    $.ajax({
                        url:'/sgd.proceso-tecnico.actualizar-formulario-emision',
                        type:'POST',
                        cache:false,
                        headers: {'X-CSRF-TOKEN': vTokenLaravel},
                        data:vFormulario
                    }).done(function(response){
                        console.log(response);
                        if(response.length==3){
                            vSpinner.css('display','none');
                            fnModalXsCheck();
                            setTimeout(function(){
                                window.location.replace('/sgd.proceso-tecnico.formulario-emision/$AL');
                            },2000);
                        }else{
                            vSpinner.css('display','none');
                            var vJsonResponse=JSON.parse(response);
                            var vKeysJsonResponse=Object.keys(vJsonResponse);
                            var vKeysFormulario=Object.keys(vObjFormulario);
                            for(var indice=0;indice<vKeysJsonResponse.length;indice++){
                                var vEtiquetaError=$('p[id="'+vKeysJsonResponse[indice]+'"]');
                                vEtiquetaError.html('');
                                var vArrayErrores=vJsonResponse[vKeysJsonResponse[indice]];
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
                    });
                }
            })
            
        }
    });
}
function fnBuscarClienteModificacionData(){
    var vValorSelect=$('input[name="nu_documento"]').val();
    if(vValorSelect){
        setTimeout(() => {
            fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de Cliente.</p> ');
        }, 1000);
        window.location.replace('/sgd.remesa.formulario-data/'+vValorSelect);
    }else{
        setTimeout(() => {
            fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de Cliente.</p> ');
        }, 1000);
        window.location.replace('/sgd.remesa.formulario-data/$AL');
    }
}
function fnProcesarModificacionData(){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>0){
            fnModalXsParaCarga('<p>¿Desea realizar la carga?<p>')
            .then((response) =>{
                if(response.isConfirmed){
                    var vFormulario=$('form[name="forms-errores-emision"]').serializeArray();
                    var vTokenLaravel=$('input[name="_token"]').val();
                    var vObjFormulario={};
                    for(var indice0=0;indice0<vFormulario.length;indice0++){
                        vObjFormulario[vFormulario[indice0].name]=vFormulario[indice0].value;
                    }
                    var vSpinner=$('div[id="spinner"]');
                    vSpinner.css('display','block');
                    $.ajax({
                        url:'/sgd.remesa.actualizar-formulario-data',
                        type:'POST',
                        cache:false,
                        headers: {'X-CSRF-TOKEN': vTokenLaravel},
                        data:vFormulario
                    }).done(function(response){
                        console.log(response);
                        if(response.length==3){
                            vSpinner.css('display','none');
                            fnModalXsCheck();
                            setTimeout(function(){
                                window.location.replace('/sgd.remesa.formulario-data/$AL');
                            },2000);
                        }else{
                            vSpinner.css('display','none');
                            var vJsonResponse=JSON.parse(response);
                            var vKeysJsonResponse=Object.keys(vJsonResponse);
                            var vKeysFormulario=Object.keys(vObjFormulario);
                            for(var indice=0;indice<vKeysJsonResponse.length;indice++){
                                var vEtiquetaError=$('p[id="'+vKeysJsonResponse[indice]+'"]');
                                vEtiquetaError.html('');
                                var vArrayErrores=vJsonResponse[vKeysJsonResponse[indice]];
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
                }
            })
            
        }
    });
}