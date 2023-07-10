function fnRecuperarContrasenia(){
    var vCorreo=$('input[name="tx_correo"]').val();
    var vUsuario=$('input[name="cd_usuario"]').val();
    var vContador=0;
    if(!vCorreo){
        var vDivCorreo=$('div[id="tx_correo"]');
        vDivCorreo.html();
        vDivCorreo.append('<center><p style="font-size:12px;color:red">El Campo est&aacute; vac&iacute;o</p></center>');
        vContador+=1;}
    if(!vUsuario){
        var vDivUsuario=$('div[id="cd_usuario"]');
        vDivUsuario.html();
        vDivUsuario.append('<center><p style="font-size:12px;color:red">El Campo est&aacute; vac&iacute;o</p></center>');
        vContador+=1;}
    if(vContador==0){
        var vMensaje='Importante| Al presionar el boton cargar Se enviar&aacute; un correo para con la nueva <b> clave.</b>.'
		var vArrayResumen=[];
        vArrayResumen.push(vMensaje);
        var vTokenLaravel=$('input[name="_token"]').val();
        var vFormulario=$('form[name="gestion-usuario"]').serializeArray();
        fnModalXsParaCarga(fnResumenCarga(vArrayResumen,'Detalle Carga de Remesa'))
        .then((response) =>{
            if(response.isConfirmed){
                $.ajax({
                    url:'/sgd.login.cambio-clave',
                    type:'POST',
                    cache:false,
                    headers: {'X-CSRF-TOKEN': vTokenLaravel},
                    data:vFormulario
                }).done(function(response){
                    console.log(response);
                    if(response=1){
                        fnModalXsCheck();
                        setTimeout(function(){
                            window.location.replace('/sgd.inicio');
                        },2000);
                    }
                }).fail(function(a,b,c){
                    console.log(a,b,c);
                });
            }
        });
        
    
    }
}