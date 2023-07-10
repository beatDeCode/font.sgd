function fnInHabilitar(pId,pIndice,pNivelForm){
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>0){
            var vTokenLaravel=$('input[name="_token"]').val();
            var vController=$('input[name="nombreController'+pNivelForm+'"]').val();
            var vSolicitud=new FormData();
			vSolicitud.append('nombreController',vController);
            vSolicitud.append(pIndice,pId);
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
                        data:vSolicitud
                    }).done(function(response){
                        console.log(response);
                        if(response=1){
                            fnModalXsCheck();
                            setTimeout(function(){
                                window.location.replace('/sgd.inicio');
                            },2000);
                        }
                    });
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