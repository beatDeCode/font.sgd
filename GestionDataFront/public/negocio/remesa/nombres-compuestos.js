function fnCargarNombresCompuestos(){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>2){
            
            var vFormulario=$('form[name="forms-nombres-compuestos"]').serializeArray();
            if(vFormulario.length>0){
                console.log(vFormulario);
                var vArray=[];
                for(var indice=0;indice<vFormulario.length;indice++){
                    if((indice+1)%6==0){
                        
                        if(vFormulario[indice-1]['value'] && vFormulario[indice-3]['value']){
                            var vNombreParaValidar=((vFormulario[indice-3]['value'])).trim().toLowerCase();
                            var vApellidoParaValidar=((vFormulario[indice-1]['value'])).trim().toLowerCase();
                            var vNombreCompleto=vFormulario[indice-4]['value'].toLowerCase();
                            
                            var vValidacionNombre=new RegExp('\\b' + vNombreParaValidar + '\\b').test(vNombreCompleto);
                            var vValidacionApellido=new RegExp('\\b' + vApellidoParaValidar + '\\b').test(vNombreCompleto);
                            console.log(vNombreCompleto,vValidacionNombre);
                            if(vValidacionNombre && vValidacionApellido){
                                var objNombres={
                                    nm_nombre1:"",
                                    nm_nombre2:"",
                                    nm_apellido1:"",
                                    nm_apellido2:"",
                                    cd_gestion_remesa:""		
                                };
                                objNombres['nm_nombre1']=(vFormulario[indice-3]['value']).trim();
                                objNombres['nm_nombre2']=(vFormulario[indice-2]['value']).trim();
                                objNombres['nm_apellido1']=(vFormulario[indice-1]['value']).trim();
                                objNombres['nm_apellido2']=(vFormulario[indice]['value']).trim();
                                objNombres['cd_gestion_remesa']=vFormulario[indice-5]['value'];
                                vArray.push(objNombres);
                                console.log(objNombres,vArray);
                            }
                            
                        }
                    }
                }
                if(vArray.length>0){
                    var vMensaje='Importante| Se está realizando la actualización de los nombres compuestos del sistema, <b>Revisar los cambios propuestos evitan que el cliente tenga un nombre incorrecto en su cuadro póliza,</b> ';
					var vArrayResumen=[];
					vArrayResumen.push(vMensaje);
                    
					fnModalMdParaCarga('<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Rango de Edades para Data &Oacute;ptima</b></li>'+'<hr>'+
                    fnTablaResumenDeCarga(vArray,'fnNombresCompuestos')+
						fnResumenCarga(vArrayResumen,'Nombres Compuestos'))
                    .then((response) =>{
                        if(response.isConfirmed){
                            
                            var _token=$('input[name="_token"]').val();
                            console.log(_token);
                            $.ajax({
                                url:'/sgd.remesa.nombres-compuestos.agregar',
                                type:'POST',
                                data: JSON.stringify(vArray),
                                headers: {'X-CSRF-TOKEN': _token},
                                contentType:'application/json;charset=utf-8'
                            }).done(function(response){
                                if(response==1){
                                    fnModalXsCheck();
										setTimeout(() => {
											window.location.replace('/sgd.remesa.nombres-compuestos/$AL');
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

function fnBuscarNombresCompuestos(){
	var vValorSelect=$('select[name="cd_remesa"] option:selected').val();
	if(vValorSelect){
		setTimeout(() => {
			fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de rangos por aliados.</p> ');
		}, 1000);
		window.location.replace('/sgd.remesa.nombres-compuestos/'+vValorSelect);
	}else{
		setTimeout(() => {
			fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de rangos por aliados.</p> ');
		}, 1000);
		window.location.replace('/sgd.remesa.nombres-compuestos/$AL');
	}
}

function fnNombresCompuestos(){
	var vValores=[];
    vValores.push('cd_gestion_remesa|C&oacute;digo gesti&oacute;n');
	vValores.push('nm_nombre1|Primer Nombre');
	vValores.push('nm_nombre2|Segundo Nombre');
    vValores.push('nm_apellido1|Primer Apellido');
	vValores.push('nm_apellido2|Segundo Apellido');
    
	return vValores;
}