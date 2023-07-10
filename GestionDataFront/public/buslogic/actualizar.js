function fnModalActualizar(pValor,pIndice){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>3){
            var vNombreController=$('input[name="nombreEtiqueta'+pIndice+'"]').val();
            var vHtml=
            '<div class="container-fluid">'+
                '<div class="col-md-12 badge bg-dark">'+
                'Actualización de '+vNombreController+
                '</div>'+
                '<hr>'+
                '<div id="forms-ajax-upd"></div>'
            '</div><hr>';
            
            fnModal(vHtml+' '+fnArmarFormUpdAjax(pValor,pIndice)+' '+
            '<div style="color:white;">'+ setTimeout(() => {
                fnArmarSelectsPorAjaxPorId(pIndice,pValor);
                return '';
            }, 500)+'</div>'
            
            ).then((response) =>{
	            if(response.isConfirmed){
                    fnActualizar(pIndice);
	            }else{}    
	        });
            //fnArmarSelectsPorAjax(pIndice);
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnActualizar(pIndice){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>0){
            var vFormulario=$('form[name="formulario-update'+pIndice+'"]').serializeArray();
            console.log(vFormulario);
            var vTokenLaravel=$('input[name="_token_md"]').val();
            var vObjFormulario={};
            for(var indice0=0;indice0<vFormulario.length;indice0++){
                vObjFormulario[vFormulario[indice0].name]=vFormulario[indice0].value;
            }
            var vSpinner=$('div[id="spinner"]');
            vSpinner.css('display','block');
            $.ajax({
                url:'/sgd.actualizar',
                type:'POST',
                cache:false,
                headers: {'X-CSRF-TOKEN': vTokenLaravel},
                data:vFormulario
            }).done(function(response){
                console.log(response,response.length);
                if(response==1){
                    vSpinner.css('display','none');
                    fnModalXsCheck();
                    var vRutaControlador=$('input[name="rutaControlador'+pIndice+'"]').val();
                    setTimeout(function(){
                        window.location.replace(vRutaControlador);
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
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/xcob-inicio');
            },2500);
        }
    });
}

function fnInHabilitar(pId,pIndice,pNivelForm){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>0){
            var vTokenLaravel=$('input[name="_token"]').val();
            var vController=$('input[name="nombreController'+pNivelForm+'"]').val();
            var vRutaControlador=$('input[name="rutaControlador'+pNivelForm+'"]').val();
            var vSpinner=$('div[id="spinner"]');
            vSpinner.css('display','block');
            var vMensaje='Importante|Se <b>eliminar&aacute; el registro</b>, se debe tener en cuenta que ser&aacute; permanentemente .'
            var vArrayResumen=[];
            vArrayResumen.push(vMensaje);
            fnModalXsParaCarga(fnResumenCarga(vArrayResumen,'Detalle'))
            .then((response) =>{
                if(response.isConfirmed){
                    $.ajax({
                        url:'/sgd.eliminar',
                        type:'POST',
                        cache:false,
                        headers: {'X-CSRF-TOKEN': vTokenLaravel},
                        data:{
                            'vData':vController+'|'+pId
                        }
                    }).done(function(response){
                        if(response=1){
                            fnModalXsCheck();
                            setTimeout(function(){
                                window.location.replace(vRutaControlador);
                            },2000);
                        }
                    }).fail(function(a,b,c){
                        console.log(a,b,c);
                    });
                }
            });
        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/xcob-inicio');
            },2500);
        }
    });
}