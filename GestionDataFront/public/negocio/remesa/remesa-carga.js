//var vServer='http://localhost:8080/';
var vServer='http://10.10.0.202:8081/';
//var vServer='http://localhost:9081/';

function fnListarRemesas(){

	$.ajax({
		url:'/sgd.remesa.listar',
		type:'get'
	}).done(function(response){
		var vNombreDT='dt-carga-remesa';
		var vTabla=fnArmarTablaDtTooltips('fnRemesaCarga',vNombreDT);
		var vDivTablaCargaRemesa=$('div[id="tabla-carga-remesa"]');
		vDivTablaCargaRemesa.html('');
		vDivTablaCargaRemesa.append(vTabla);

		var vDatatable=$('table[id="'+vNombreDT+'"]').DataTable(
			fnConfiguracionDataTable(false,false,7));
		var vArregloDt={};
		for(var indice=0;indice<response.length;indice++){
			var vArregloDt=
			[
				response[indice]['cd_remesa'],
				response[indice]['nu_consecutivo_remesa'],
				response[indice]['fe_registro'],
				response[indice]['nm_remesa'],
				response[indice]['cd_usuario'],
				response[indice]['de_producto'],
				response[indice]['de_aliado'],
				response[indice]['nu_registros_estimados'],
				fnBarraProgeso(response[indice]['po_progreso']),
				response[indice]['st_remesa'],
				'<a class="badge bg-success" style="text-decoration:none;" href="'+vServer+'sgd.logs/'+response[indice]['cd_remesa']+'">Log</a>'
			]
			vDatatable.row.add(vArregloDt).draw(false);
		}
		
	}).fail(function(a,b,c){
		console.log(a,b,c);
	});
}

fnListarRemesas();

function fnCargarRemesa(){
	var vArchivoValidacion=$('input[name="tx_archivo"]');
	var vArchivo=vArchivoValidacion[0].files;
	
	var vNombreArchivo="";
	if(vArchivo.length>0){
		vNombreArchivo=vArchivo[0].name;
	}
	var vFormulario=$('form[name="remesa-carga"]').serializeArray();
	var objSerializeForm={
			name:'tx_archivo',
			value:vNombreArchivo
		}
	vFormulario.push(objSerializeForm);
	var vContadorErrores=fnValidar(vFormulario);
	var vValidacion=vNombreArchivo.split('.');
	if(vContadorErrores>0){

	}else{
		console.log(vValidacion[1],vValidacion.length);
		if(vValidacion.length==2 && vValidacion[1]=='xlsx'){
			var vAliado='Aliado|'+$('select[name="cd_aliado"] option:selected').html();
			var vProducto='Producto|'+$('select[name="cd_producto"] option:selected').html();
			var vNmArchivo='Nombre del Archivo|'+vNombreArchivo;
			var vMensaje='Importante|La <b>DATA</b> se cargar&aacute; de forma <b>Preliminar</b>, para que sea <b>Definitiva</b> debe actualizarse el proceso de Validaci&oacuten; por <b>Seguro Social</b> y de los <b>Nombres Compuestos</b> ,los <b>Procesos T&eacute;cnicos</b> iniciaran cuando la <b>DATA</b> sea definitiva.'
			var vArrayResumen=[];
			vArrayResumen.push(vAliado);vArrayResumen.push(vProducto);vArrayResumen.push(vNmArchivo);vArrayResumen.push(vMensaje);
			fnModalXsCentrado(fnResumenCarga(vArrayResumen,'Detalle Carga de Remesa'))
				.then((response) =>{
					if(response.isConfirmed){
						var vSolicitud=new FormData();
						vSolicitud.append('txarchivo',vArchivo[0]);
						for(var indice=0;indice<vFormulario.length ;indice++){
							vSolicitud.append(vFormulario[indice]['name'],vFormulario[indice]['value']);
						}
						$.ajax({
							url:'/sgd.remesa.agregar',
							type:'POST',
							contentType:false,
							processData:false,
							cache: false,
							data:vSolicitud
						}).done(function(response){
							fnModalXsCheck();
							setTimeout(function(){
								window.location.replace('/sgd.remesa.carga')
							},2000);
						}).fail(function (a,b,c){
							console.log(a);
							console.log(b);
							console.log(c);
						});
					}
				});
		}else{
			console.log();
			var vPArchivo=$('p[id="tx_archivo"]');
			vPArchivo.html('');
			vPArchivo.append('La extensi&oacute;n del archivo debe ser XLS(Excel < 2007), XLSX (Excel >2007).');
		}
		
	}
}
