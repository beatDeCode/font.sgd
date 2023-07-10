function fnBuscarNiveles(){
	var vValorSelect=$('select[name="nu_nivel"] option:selected').val();
	if(vValorSelect){
		setTimeout(() => {
			fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de Variables por Niveles.</p> ');
		}, 1000);
		window.location.replace('/sgd.campania.variables/'+vValorSelect);
	}else{
		setTimeout(() => {
			fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de Variables por Niveles.</p> ');
		}, 1000);
		window.location.replace('/sgd.campania.variables/$AL');
	}
}
function fnEliminar(pCdVariable,pTxVariable,pNuNivel){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
		if(response.length>2){
			var vMensaje='Importante|La variable <b>'+pTxVariable+'</b> se est&aacute; considerando eliminar';
			var vArrayResumen=[];
			vArrayResumen.push(vMensaje);
			
			fnModalXsParaCarga(
				'<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Eliminaci&oacute;n de Rango de Edades</b></li>'+'<hr>'+
				fnResumenCarga(vArrayResumen,'Procesos T&eacute;cnicos')).then((response) =>{
				if(response.isConfirmed){
					$.ajax({
						url:'/sgd.campania.variables-eliminar/'+pCdVariable,
						type:'GET'
					}).done(function(response){
						console.log(response);
						if(response==1){
							fnModalXsCheck();
							setTimeout(() => {
								window.location.replace('/sgd.campania.variables/'+pNuNivel)
							}, 1500);
						}else{
							fnModalXsCentrado('El proceso posee un error.');
						}
					})
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



function fnCargaVariables(){
	$.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
    	if(response.length>2){
			var vFormulario=$('form[name="forms-variables"]').serializeArray();
            console.log(vFormulario);
			if(vFormulario.length>0){
				var vArray=[];
				var vContadorRegistros=0;
                console.log(vFormulario);
				for(var indice=0;indice<vFormulario.length;indice++){
					if((indice+1)%7==0){
						if(vFormulario[indice-4]['value']){
							vContadorRegistros+=1;
							var objNombres={
								cd_variable:'',
								nu_nivel:'',
								tx_variable:'',
								in_dependencia:'',
                                cd_relacion:'',
								cd_accion:'',
								in_decision_final:'',
								};
                                objNombres['cd_variable']=vFormulario[indice-6]['value'];
								objNombres['nu_nivel']=vFormulario[indice-5]['value'];
								objNombres['tx_variable']=vFormulario[indice-4]['value'];
								objNombres['in_dependencia']=vFormulario[indice-3]['value'];
								objNombres['cd_relacion']=vFormulario[indice-2]['value'];
								objNombres['cd_accion']=vFormulario[indice-1]['value'];
								objNombres['in_decision_final']=vFormulario[indice]['value'];
								vArray.push(objNombres);

						}
					}
				}
				console.log(vArray);
				if(vContadorRegistros==0){
					fnModalXs('No existen Valores Para El formulario.');
				}
				if(vArray.length>0){
                    var vMensaje='Importante|Las <b>Variables</b> est&aacute;n relacionadas al formulario de Campa&ntilde;ia. Al modificarlo est&aacute; realizando cambios en los <b>paneles de Campa&ntilde;ia y Estad&iacute;sticas</b>';
                    var vArrayResumen=[];
                    vArrayResumen.push(vMensaje);
                    fnModalMdParaCarga('<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Variables de Formulario de Campa&ntilde;a</b></li>'+'<hr>'+fnTablaResumenDeCarga(vArray,'fnVariables')+
                        fnResumenCarga(vArrayResumen,'Procesos T&eacute;cnicos')).
                        then((response) =>{
                        if(response.isConfirmed){
                            var _token=$('input[name="_token"]').val();
                            $.ajax({
                                url:'/sgd.campania.variables-agregar',
                                type:'POST',
                                headers: {'X-CSRF-TOKEN': _token},
                                data: JSON.stringify(vArray),
                                contentType:'application/json;charset=utf-8'
                            }).done(function(response){
                                console.log(response);
                                var vCdAliado=$('input[name="nu_nivel"]').val();
                                if(response==1){
                                    fnModalXsCheck();
                                    setTimeout(() => {
                                        window.location.replace('/sgd.campania.variables/'+vCdAliado)
                                    }, 1500);
                                }else{
                                    fnModalXsCentrado('El proceso posee un error.');
                                }
                                
                            }).fail(function(a,b,c){
                                console.log(a,b,c);
                            });
                            
                        }else{
                            
                        }
                    });
				}
				
				
			}else{
				fnModalXs('No existen Valores Para El formulario.');
			}
		}else{
            fnModalSesion();
            setTimeout(function(){
                window.location.replace('/sgd.inicio');
            },2500);
        }
	});
}
function fnVariables(){
	var vValores=[];
	vValores.push('tx_variable|Nombre Variable');
	vValores.push('in_dependencia|Dependencia');
    vValores.push('cd_relacion|Relaci&oacute;n');
    vValores.push('cd_accion|Acción');
	return vValores;
}

function fnCambiarVariableDeNoContactado(){
	$.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
    	if(response.length>2){
    		var vCdVariableNc=$('select[name="cd_variable_nc"] option:selected');
            var vCdParametro=$('input[name="cd_parametro"]');
    		var vMensaje='Importante|La <b>Variable de Cierre</b> al cierre del contacto reemplaza los datos no gestionados de la Campa&ntilde;ia. Al modificarlo est&aacute; realizando cambios en los <b>paneles de Campa&ntilde;ia y Estad&iacute;sticas</b>';
    		var vMensajeVariable='Valor de la Variable|'+vCdVariableNc.text();
            var vArrayResumen=[];
            vArrayResumen.push(vMensajeVariable);
            vArrayResumen.push(vMensaje);
            fnModalMdParaCarga('<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Variables de Cierre de Contacto de la  Campa&ntilde;a</b></li>'+'<hr><center> <b>Valor de la Variable de Cierre:</b> '+vCdVariableNc.text()+'</center>'+
            fnResumenCarga(vArrayResumen,'Campa&ntilde;a')).
                then((response) =>{
                	if(response.isConfirmed){
						if(vCdVariableNc){
							$.ajax({
								url:'/sgd.campania.variables-de-cierre/'+vCdParametro.val()+'/'+vCdVariableNc.val(),
								type:'GET'
							}).done(function(response){
								if(response==1){
									fnModalXsCheck();
                                    setTimeout(() => {
                                        window.location.replace('/sgd.campania.variables/$AL')
                                    }, 1500);
								}
							}).fail(function(a,b,c){
								console.log(a,b,c);
							});
						}
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


