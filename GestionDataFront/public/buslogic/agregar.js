function fnModalAgregar(pIndice,pTitulo){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>3){
            var vHtml=
            '<div class="container-fluid">'+
                '<div class="col-md-12 badge bg-dark">'+
                    pTitulo+
                '</div>'+
                '<hr>'+
                fnArmarForm(pIndice)+ 
            '</div><hr>';
            fnModal(vHtml).then((response) =>{
	            if(response.isConfirmed){
                    fnAgregar(pIndice);
	            }else{}    
	        });
            fnArmarSelectsPorAjax(pIndice);

        }else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
    });
}

function fnAgregar(pIndice){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>0){
            var vFormulario=$('form[name="formulario-agregar'+pIndice+'"]').serializeArray();
            var vTokenLaravel=$('input[name="_token_md"]').val();
            //var vNombreControlador=$('input[name="nombreController_cd"]').val();
            var vObjFormulario={};
            for(var indice0=0;indice0<vFormulario.length;indice0++){
                vObjFormulario[vFormulario[indice0].name]=vFormulario[indice0].value;
            }
            var vSpinner=$('div[id="spinner"]');
            vSpinner.css('display','block');
            $.ajax({
                url:'/sgd.agregar',
                type:'POST',
                cache:false,
                headers: {'X-CSRF-TOKEN': vTokenLaravel},
                data:vFormulario
            }).done(function(response){
                console.log(response,response.length);
                if(response.length==3){
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