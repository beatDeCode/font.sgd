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
function fnGenerarVariable0(){
	$.ajax({
		    url:'/sgd.sesion.validar/',
		    type:'GET',
		}).done(function(response){
			var vResponse=response.length;
			if(vResponse>0){
				var vParam1=$('select[name="cd_campania"] option:selected').val();
				var vSeparacionStr=vParam1.split('-');
				//if(vParam1 && vParam2){
					var vTituloFecha=$('p[id="aFecha"]');
					vTituloFecha.html('');
					
					vTituloFecha.html('<hr> <div style="text-align:left;"><span class="badge bg-dark col-md-12">Estadísticas General de Contactos</span></div>'+
					'<br><b>Campa&ntilde;a # '+vParam1+'</b> ');
					 $.ajax({
						url:'/sgd.campania.estadisticas-variable0/'+vSeparacionStr[0]+'/'+vSeparacionStr[1],
						type:'GET',
					}).done(function(response){
						if(response.length>0){
							vArrayData=[];
							vArrayLabels=[];
							vArrayColores=[];
							var vContador=0;
							for(var graficos=0;graficos<response.length;graficos++){
								vArrayLabels[graficos]=response[graficos]['tx_variable']+'( '+response[graficos]['po_numerico']+' % )';
								vArrayData[graficos]=response[graficos]['po_numerico'];
								vArrayColores[graficos]=fnColores(graficos);
								vContador+=parseInt(response[graficos]['ca_registros']);
							}
							console.log(response);
							var vDivGrafico=$('div[id="cjgrafico00"]');
							vDivGrafico.html('');
							var vDivTabla=$('div[id="tbgrafico00"]');
							vDivTabla.html('');	
							var vTablaResumen=fnArmarTablaDt('fnTableParaGraficosGenerales','dtgrafico00');
							vDivTabla.append(vTablaResumen);
							var vElementoTabla=$('table[id="dtgrafico00"]');
							var vDataTable=vElementoTabla.DataTable(fnConfiguracionDataTable(true,false,15));
							var vArrayDataTable=[];
							for(var datatable=0;datatable<response.length;datatable++){
								vArrayDataTable.push(response[datatable]['tx_variable']);
								vArrayDataTable.push(response[datatable]['ca_registros']);
								vArrayDataTable.push(response[datatable]['po_numerico']);
								vDataTable.row.add(
										vArrayDataTable	
									).draw(false);
								vArrayDataTable=[];
								
							}
							vDataTable.row.add(['<b>Total</b>',vContador,'100%']).draw(false);
							
							vDivGrafico.append('<canvas id="cjgrafico0" height="40vh" width="65vw" ></canvas>');
							fnConstruirGraficoDona(vArrayData,vArrayLabels,vArrayColores,'cjgrafico0','Estadísticas Generales De Contacto');
				    		
						}
					})
				
			}else{
				
			}
		});
}
function fnGenerarPrimerosCuadros(){
	fnGenerarVariable0();
	fnGenerarPrimerCuadro();
}

function fnGenerarPrimerCuadro(){
	$.ajax({
		    url:'/sgd.sesion.validar/',
		    type:'GET',
		}).done(function(response){
			var vResponse=response.length;
			if(vResponse>0){
				var vParam1=$('select[name="cd_campania"] option:selected').val();
				var vSeparacionStr=vParam1.split('-');
				//if(vParam1 && vParam2){
					var vTituloFecha=$('p[id="aFecha"]');
					vTituloFecha.html('');
					
					vTituloFecha.html('<hr> <div style="text-align:left;"><span class="badge bg-dark col-md-12">Estadísticas General de Contactos</span></div>'+
					'<br><b>Campa&ntilde;a # '+vParam1+'</b> ');
					 $.ajax({
						url:'/sgd.campania.estadisticas-generales/'+vSeparacionStr[0]+'/'+vSeparacionStr[1],
						type:'GET',
					}).done(function(response){
						if(response.length>0){
							
							vArrayData=[];
							vArrayLabels=[];
							vArrayColores=[];
							var vContador=0;
							for(var graficos=0;graficos<response.length;graficos++){
								vArrayLabels[graficos]=response[graficos]['tx_variable']+'( '+response[graficos]['po_numerico']+' % )';
								vArrayData[graficos]=response[graficos]['po_numerico'];
								vArrayColores[graficos]=fnColores(graficos);
								vContador+=parseInt(response[graficos]['ca_registros']);
							}
							var vDivGrafico=$('div[id="cjgrafico10"]');
							vDivGrafico.html('');
							var vDivTabla=$('div[id="tbgrafico10"]');
							vDivTabla.html('');	
							var vTablaResumen=fnArmarTablaDt('fnTableParaGraficosGenerales','dtgrafico10');
							vDivTabla.append(vTablaResumen);
							var vElementoTabla=$('table[id="dtgrafico10"]');
							var vDataTable=vElementoTabla.DataTable(fnConfiguracionDataTable(true,false,15));
							var vArrayDataTable=[];
							for(var datatable=0;datatable<response.length;datatable++){
								vArrayDataTable.push(response[datatable]['tx_variable']);
								vArrayDataTable.push(response[datatable]['ca_registros']);
								vArrayDataTable.push(response[datatable]['po_numerico']);
								vDataTable.row.add(
										vArrayDataTable	
									).draw(false);
								vArrayDataTable=[];
								
							}
							vDataTable.row.add(['<b>Total</b>',vContador,'100%']).draw(false);
							
							vDivGrafico.append('<canvas id="cjgrafico1" height="40vh" width="65vw" ></canvas>');
							fnConstruirGraficoDona(vArrayData,vArrayLabels,vArrayColores,'cjgrafico1','Estadísticas Generales Por Variables');
							$('div[id="div-select-grafico-2"]').css('display','block');
							$('div[id="div-select-grafico-3"]').css('display','block');
							$('input[name="input-switch"]').val(1);
							
				    		
						}
					})
				
			}else{
				
			}
		});
}
function fnGenerarGraficoPorUsuarios(){
	$.ajax({
		    url:'/sgd.sesion.validar/',
		    type:'GET',
		}).done(function(response){
			var vResponse=response.length;
			if(vResponse>0){
				var vParam1=$('select[name="cd_campania"] option:selected').val();
				var vSeparacionStr=vParam1.split('-');
				var vParam2=$('select[name="cd_variable"] option:selected');
					var vTituloFecha=$('p[id="aFecha"]');
					vTituloFecha.html('');
					
					vTituloFecha.html('<hr> <div style="text-align:left;"><span class="badge bg-dark col-md-12">Estadísticas General de Contactos</span></div>'+
					'<br><b>Campa&ntilde;a # '+vParam1+'</b> ');
					 $.ajax({
						url:'/sgd.campania.estadisticas-por-usuario/'+vSeparacionStr[0]+'/'+vParam2.val(),
						type:'GET',
					}).done(function(response){
						if(response.length>0){
							vArrayData=[];
							vNombreVariable='';
							vArrayLabels=[];
							vArrayColores=[];
							var vContador=0;
							for(var contador=0;contador<response.length;contador++){
								vContador+= parseInt(response[contador]['ca_registros']);
							}
							for(var graficos=0;graficos<response.length;graficos++){
								vArrayLabels[graficos]=response[graficos]['nm_usuario'];
								vArrayData[graficos]=
										parseInt(response[graficos]['po_efectividad'])
										//Math.round( ((parseInt(response[graficos]['ca_registros'])*100)/vContador) * 100) / 100
										;
								vArrayColores[graficos]=fnColores(graficos);

							}
							var vDivGrafico=$('div[id="cjgrafico20"]');
							vDivGrafico.html('');
							vDivGrafico.append('<canvas id="cjgrafico2" height="45vh" width="70vw" ></canvas>');
							fnConstruirGraficoDeBarras(vArrayData,vArrayLabels,'cjgrafico2',vArrayColores,'Estadísticas Por Efectividad De Los Operadores Para La Variable '+vParam2.text());

							var vDivTabla=$('div[id="tbgrafico20"]');
							vDivTabla.html('');	
							var vTablaResumen=fnArmarTablaDt('fnTableParaGraficosGenerales','dtgrafico20');
							vDivTabla.append(vTablaResumen);
							var vElementoTabla=$('table[id="dtgrafico20"]');
							var vDataTable=vElementoTabla.DataTable(fnConfiguracionDataTable(true,false,15));
							var vArrayDataTable=[];

							for(var datatable=0;datatable<response.length;datatable++){
								vArrayDataTable.push(response[datatable]['nm_usuario']);
								vArrayDataTable.push(response[datatable]['ca_registros']);
								vArrayDataTable.push(Math.round( ((parseInt(response[datatable]['ca_registros'])*100)/vContador) * 100) / 100 );
								vDataTable.row.add(
										vArrayDataTable	
									).draw(false);
								vArrayDataTable=[];
								
							}
							vDataTable.row.add(['<b>Total</b>',vContador,'100%']).draw(false);
							$('input[name="input-switch"]').val(1);

				    		
						}
					})
				
			}else{
				
			}
		});
}

function fnGenerarGraficoPorNumeroConsecutivo(){
	$.ajax({
		    url:'/sgd.sesion.validar/',
		    type:'GET',
		}).done(function(response){
			var vResponse=response.length;
			if(vResponse>0){
				var vParam1=$('select[name="cd_campania"] option:selected').val();
				var vSeparacionStr=vParam1.split('-');
				var vParam2=$('select[name="nu_nivel"] option:selected').val();
					var vTituloFecha=$('p[id="aFecha"]');
					vTituloFecha.html('');
					
					vTituloFecha.html('<hr> <div style="text-align:left;"><span class="badge bg-dark col-md-12">Estadísticas General de Contactos</span></div>'+
					'<br><b>Campa&ntilde;a # '+vParam1+'</b> ');
					 $.ajax({
						url:'/sgd.campania.estadisticas-por-contacto/'+vSeparacionStr[0]+'/'+vParam2,
						type:'GET',
					}).done(function(response){
		
						if(response.length>0){
							vArrayData=[];
							vNombreVariable='';
							vArrayLabels=[];
							vArrayColores=[];
							var vContador=0;
							for(var contador=0;contador<response.length;contador++){
								vContador+= parseInt(response[contador]['ca_registros']);
							}
							for(var graficos=0;graficos<response.length;graficos++){
								vArrayLabels[graficos]=response[graficos]['tx_variable']+
									'( '+ (Math.round( ((parseInt(response[graficos]['ca_registros'])*100)/vContador) * 100) / 100)  +' % )';
								vArrayData[graficos]=
										//parseInt(response[graficos]['ca_registros'])
										Math.round( ((parseInt(response[graficos]['ca_registros'])*100)/vContador) * 100) / 100
										;
								vArrayColores[graficos]=fnColores(graficos);

							}
							var vDivGrafico=$('div[id="cjgrafico30"]');
							vDivGrafico.html('');
							vDivGrafico.append('<canvas id="cjgrafico3" height="45vh" width="70vw" ></canvas>');
							fnConstruirGraficoDona(vArrayData,vArrayLabels,vArrayColores,'cjgrafico3','Estadísticas por Intento de Contacto # '+vParam2+'.');

							var vDivTabla=$('div[id="tbgrafico30"]');
							vDivTabla.html('');	
							var vTablaResumen=fnArmarTablaDt('fnTableParaGraficosGenerales','dtgrafico30');
							vDivTabla.append(vTablaResumen);
							var vElementoTabla=$('table[id="dtgrafico30"]');
							var vDataTable=vElementoTabla.DataTable(fnConfiguracionDataTable(true,false,15));
							var vArrayDataTable=[];

							for(var datatable=0;datatable<response.length;datatable++){
								vArrayDataTable.push(response[datatable]['tx_variable']);
								vArrayDataTable.push(response[datatable]['ca_registros']);
								vArrayDataTable.push(Math.round( ((parseInt(response[datatable]['ca_registros'])*100)/vContador) * 100) / 100 );
								vDataTable.row.add(
										vArrayDataTable	
									).draw(false);
								vArrayDataTable=[];
								
							}
							vDataTable.row.add(['<b>Total</b>',vContador,'100%']).draw(false);
							$('input[name="input-switch"]').val(1);
				    		
						}
					})
				
			}else{
				
			}
		});
}

function fnColores(pIndex){
	var vArray=[];
	/*vArray[0]='rgb(220, 20, 60)';//rojo
	vArray[1]='rgb(255, 215, 0)';//azul 
	vArray[2]='rgb(0, 191, 255)';//amarillo
	vArray[3]='rgb(0, 255, 127)';//verde primavera
	vArray[4]='rgb(119, 136, 153)';//gris

	vArray[5]='rgb(240, 128, 128)';//rojo claro
	vArray[6]='rgb(135, 206, 250)';//azul claro
	vArray[7]='rgb(240, 255, 240)';//verde claro
	vArray[8]='rgb(255, 255, 224)';//amarillo claro
	vArray[9]='rgb(211, 211, 211)'; //kakhi*/

	vArray[0]='rgb(255, 215, 0)';//gold
	vArray[1]='rgb(30, 144, 255)';//azul oscuro
	vArray[2]='rgb(255, 0, 0)';//rojo 
	vArray[3]='rgb(127, 255, 212)';//aquamarine
	vArray[4]='rgb(119, 136, 153)';//gris
	vArray[5]='rgb(255, 105, 180)';//rosado
	vArray[6]='rgb(30, 144, 255)';//azul rey
	vArray[7]='rgb(220, 20, 60)'; //rojo divino
	vArray[8]='rgb(240, 248, 255)';//azul alicia
	vArray[9]='rgb(127, 255, 0)';//verde loco
	vArray[10]='rgb(240, 230, 140)';//mostaza
	return vArray[pIndex];
}

function fnConstruirGrafico(vArrayData,vArrayLabels,vArrayColores,vIdGrafico,vTitulo){
	const ctx = document.getElementById(vIdGrafico);
	const myChart = new Chart(ctx,{
	    type: 'pie',
	    data: {
	        labels: vArrayLabels,
	        datasets: [{
	            label: vTitulo,
	            data: vArrayData,
	            backgroundColor: vArrayColores,
	            hoverOffset: 4
	            }]
	    },
	    plugins: {
            legend: {
                labels: {
                    // This more specific font property overrides the global property
                    font: {
                        size: 16
                    }
                }
            }
        }
	    //plugins: [ChartDataLabels],
	    //options: {
			//plugins:{
				/*datalabels:{
					
					formatter:(value,ctx)=>{
						console.log(value,ctx);
						return value+" %";
					},
					color: 'black',
			        labels: {
			          title: {
			            font: {
			              weight: 'bold'
			            }
			          }
			        }
				}*/
			//},
	        
	    //}
	});
}
function fnConstruirGraficoDeBarras(vArrayData,vArrayLabels,vIdGrafico,vNombreVariable,vTitulo){
	var ctx = document.getElementById(vIdGrafico).getContext('2d');
	var color = Chart.helpers.color;
	var barChartData = {
			labels: vArrayLabels,
			datasets: [{
				label: '% Efectividad',
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 1,
				fill: false,
				data: vArrayData
			}],


	};

	window.myBar = new Chart(ctx, 
	{
		type: 'bar',
		data: barChartData,
		options: {
			responsive: true,
			legend: {
				position: 'top',
			},
			title: {
				display: true,
				text: vTitulo
			},
            scales: {
	            yAxes: [{
	                ticks: {
	                    suggestedMin: 0,
	                    suggestedMax: 40
	                }
	            }]
        	}
		}
	});


}
function fnConstruirGraficoDona(vArrayData,vArrayLabels,vArrayColores,vIdGrafico,vTitulo){
	var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: 
						vArrayData
					,
					backgroundColor: 
						vArrayColores
					,
					label: vTitulo
				}],
				labels: 
					vArrayLabels
				
			},
			options: {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: vTitulo
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		};

		var ctx = document.getElementById(vIdGrafico).getContext('2d');
		window.myDoughnut = new Chart(ctx, config);
		
}

function fnRecargarEstadisticas(){
	var vInputSwicth=$('input[name="input-switch"]').val();
	if(vInputSwicth==1){
		fnGenerarVariable0();
		fnGenerarPrimerCuadro();
		fnGenerarGraficoPorUsuarios();
		fnGenerarGraficoPorNumeroConsecutivo();
	}
	
}
setInterval(
	function(){
		fnRecargarEstadisticas();
	},15000
);


