
function fnCargaRangoEdades(){
	$.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
    	if(response.length>2){
			var vFormulario=$('form[name="forms-rango-edades"]').serializeArray();
			if(vFormulario.length>0){
				var vArray=[];
				var vContadorRegistros=0;
				for(var indice=0;indice<vFormulario.length;indice++){
					if((indice+1)%5==0){
						if(vFormulario[indice]['value'] && vFormulario[indice-1]['value']){
							vContadorRegistros+=1;
							var objNombres={
								cd_aliado:'',
								cd_edad:'',
								cd_rango_edad:'',
								min_edad:'',
								max_edad:'',
								};
								objNombres['cd_aliado']=vFormulario[indice-4]['value'];
								objNombres['cd_edad']=vFormulario[indice-3]['value'];
								objNombres['cd_rango_edad']=vFormulario[indice-2]['value'];
								objNombres['min_edad']=vFormulario[indice-1]['value'];
								objNombres['max_edad']=vFormulario[indice]['value'];
								vArray.push(objNombres);
						}
					}
				}
				if(vContadorRegistros==0){
					fnModalXs('No existen Valores Para El formulario.');
				}
				if(fnRevisarRepetidos(vArray)>0){
					fnModalXs('Los par&aacutemetros sumistrados tienen errores, es decir, alg&uacuten valor posee un rango erron&eacuteo o se repiten. <p><b>Los Rangos deben estar ordenados y no deben incluir valor que ya estan tomados por otros, ejemplo si existe el rango desde 1 a 18, no podemos colocar uno de 3 a 16</b></p>','Volver');
				}else{
					if(vArray.length>0){
						var vMensaje='Importante|Las <b>Edades</b> que se estan cargando afectan los rangos en el panel de data óptima. <b>Al modificarlo está condicionando los procesos t&eacute;cnicos a esta decision</b>';
						var vArrayResumen=[];
						vArrayResumen.push(vMensaje);
						fnModalXsParaCarga('<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Rango de Edades para Data &Oacute;ptima</b></li>'+'<hr>'+fnTablaResumenDeCarga(vArray,'fnRangoEdades')+
							fnResumenCarga(vArrayResumen,'Procesos T&eacute;cnicos')).
							then((response) =>{
							if(response.isConfirmed){
								var _token=$('input[name="_token"]').val();
								$.ajax({
									url:'/sgd.rangos-edades.agregar',
									type:'POST',
									headers: {'X-CSRF-TOKEN': _token},
									data: JSON.stringify(vArray),
									contentType:'application/json;charset=utf-8'
								}).done(function(response){
									var vCdAliado=$('input[name="cd_aliado_xs"]').val();
									if(response==1){
										fnModalXsCheck();
										setTimeout(() => {
											window.location.replace('/sgd.configurar.rangos-edades/'+vCdAliado)
										}, 1500);
									}else{
										fnModalXsCentrado('El proceso posee un error.');
									}
									
								});
								
							}else{
								
							}
						});
					}
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

function fnRevisarRepetidos(vObjeto){
	var vContador=0;
	var vArrayRangos=[];
	var vValoresOrdenados=[];
	for(var indice=0;indice<vObjeto.length;indice++){
		//console.log(vObjeto[indice]['max_edad'].length);
		if(vObjeto[indice]['max_edad'].length>2){
			vArrayRangos.push(parseFloat(vObjeto[indice]['min_edad']+'.'+vObjeto[indice]['max_edad']).toFixed(3));
		}else{
			//console.log(parseFloat(vObjeto[indice]['min_edad']+'.'+vObjeto[indice]['max_edad']).toFixed(2));
			vArrayRangos.push(parseFloat(vObjeto[indice]['min_edad']+'.'+vObjeto[indice]['max_edad']).toFixed(2));
		}
		
		for(var indice2=0;indice2<vObjeto.length;indice2++){
			if(indice==indice2){}else{
				
				if(vObjeto[indice]['min_edad']==vObjeto[indice2]['max_edad']){
					vContador+=1;
				}
				if(vObjeto[indice]['min_edad']==vObjeto[indice2]['min_edad']){
					vContador+=1;
				}
				if(vObjeto[indice]['max_edad']==vObjeto[indice2]['max_edad']){
					vContador+=1;
				}
			}
		}
	}
	var vValoresOrdenados=metodoBurbuja(vArrayRangos);
	for(var indice4=vValoresOrdenados.length-1;indice4>=0;indice4--){
		
		var vMaxIndice4=parseInt((vValoresOrdenados[indice4]+'').split('.')[1]);
		var vMinIndice4=parseInt((vValoresOrdenados[indice4]+'').split('.')[0]);
		for(var indice5=indice4;indice5>=0;indice5--){
			if(indice4==indice5){//console.log('---',vMinIndice4,vMaxIndice4);
			}else{
				//console.log(indice5,indice4,vValoresOrdenados,vArrayRangos,vObjeto);
				var vMaxIndice5=parseInt((vValoresOrdenados[indice5]+'').split('.')[1]);
				var vMinIndice5=parseInt((vValoresOrdenados[indice5]+'').split('.')[0])
				//console.log('+++',vMinIndice5,vMaxIndice5,'---',vMinIndice4,vMaxIndice4);
				if(vMaxIndice5>vMaxIndice4){
					vContador+=1;
				}
				if(vMinIndice5>vMaxIndice4){
					vContador+=1;
				}
				if(vMinIndice5>vMinIndice4){
					vContador+=1;
				}
				if(vMaxIndice5>vMinIndice4){
					vContador+=1;
				}
				
			}
		}
	}
	return 	vContador;
}

function metodoBurbuja(items) {  
	//console.log('Burbuja Ent',items);
    var length = items.length;  
    for (var i = 0; i < length; i++) { 
        for (var j = 0; j < (length - i - 1); j++) { 
			//console.log('For Burbuja',parseFloat(items[i]),parseFloat(items[j]));
           if(parseFloat(items[j]) > parseFloat(items[j+1])) {
                   	var tmp = parseFloat(items[j]); 
					   items[j] = parseFloat([j+1]); 
					   items[j+1] = parseFloat(tmp); 
            }
        }        
    }
	//console.log('Burbuja Salida',items);
    return items;

}
function fnBuscarRangoAliado(){
	var vValorSelect=$('select[name="cd_aliado"] option:selected').val();
	if(vValorSelect){
		setTimeout(() => {
			fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de rangos por aliados.</p> ');
		}, 1000);
		window.location.replace('/sgd.configurar.rangos-edades/'+vValorSelect);
	}else{
		setTimeout(() => {
			fnModalXs('<div class="spinner offset-md-5"></div><p>Realizando B&uacute;squeda de rangos por aliados.</p> ');
		}, 1000);
		window.location.replace('/sgd.configurar.rangos-edades/$AL');
	}
}

function fnRangoEdades(){
	var vValores=[];
	vValores.push('min_edad|Edad M&iacutenima');
	vValores.push('max_edad|Edad M&aacutexima');
	return vValores;
}

function fnEliminar(pCdRangoEdad,pCdAliado,pMinEdad, pMaxEdad){
	$.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
		if(response.length>2){
			var vMensaje='Importante|La <b>Edad entre '+pMinEdad+' y '+pMaxEdad+'</b> se est&aacute; considerando eliminar';
			var vArrayResumen=[];
			vArrayResumen.push(vMensaje);
			
			fnModalXsParaCarga(
				'<li style="list-style: disclosure-closed;font-size:14px;padding-left:10px;"><b>Eliminaci&oacute;n de Rango de Edades</b></li>'+'<hr>'+
				fnResumenCarga(vArrayResumen,'Procesos T&eacute;cnicos')).then((response) =>{
				if(response.isConfirmed){
					$.ajax({
						url:'/sgd.rangos-edades.eliminar/'+pCdRangoEdad,
						type:'GET'
					}).done(function(response){
						console.log(response);
						if(response==1){
							fnModalXsCheck();
							setTimeout(() => {
								window.location.replace('/sgd.configurar.rangos-edades/'+pCdAliado)
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