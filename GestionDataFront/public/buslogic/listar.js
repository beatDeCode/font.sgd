function fnListarGlobal(indice){
    var vNombreController=$('input[name="nombreController'+indice+'"]').val(); 
    var vFuncionController=$('input[name="funcionController'+indice+'"]').val();
    var vDatatable='';
    var vArmadoDatatable='';
    var vNombreDataTable='';
    var vDivParaAnexaDataTable=$('div[id="datatable-listar'+indice+'"]');
    $.ajax({
        url:'/sgd.sesion.validar/',
        type:'GET',
    }).done(function(response){
        if(response.length>0){
            $.ajax({
                url:'/sgd.listar.datatable/'+vNombreController,
                type:'GET',
            }).done(function(response){
                
                vDivParaAnexaDataTable.html('');
                vNombreDataTable=window[vFuncionController]()[2];
                var vIndices=window[vFuncionController]()[1];
                var vIdPojo=window[vFuncionController]()[3];
                var vInputsHidden=window[vFuncionController]()[4];
                vArmadoDatatable=fnArmarTablaDt(vFuncionController,vNombreDataTable);
                vDivParaAnexaDataTable.append(vArmadoDatatable);
                vDatatable=$('table[id="'+vNombreDataTable+'"]').DataTable(fnConfiguracionDataTable(true,false,5));
                var vHtmlInputsHidden='';
                for(var b=0;b<response.length;b++){
                    var vArrayValores=[];
                    for(var c=0;c<vIndices.length;c++){
                        vArrayValores.push(response[b][vIndices[c]]);
                    }
                    if(vInputsHidden){
                        
                        for(indice1=0;indice1<vInputsHidden.length;indice1++){
                            vHtmlInputsHidden+='<input type="hidden" name="'+response[b][vIdPojo]+vInputsHidden[indice1]+'" value="'+response[b][vInputsHidden[indice1]]+'" >';
                        }
                    }
                    var vBotonEliminar='';
                    if(response[b]['st_eliminar']==1){
                        vBotonEliminar='<a class="badge bg-danger" onclick="fnInHabilitar(\''+response[b][vIdPojo]+'\',\''+vIdPojo+'\','+indice+')" > Eliminar</a>';
                    }
                    vArrayValores.push('<a class="badge bg-info" onclick="fnModalActualizar(\''+response[b][vIdPojo]+'\','+indice+')" >Actualizar</a> ' +
                        vBotonEliminar+
                        vHtmlInputsHidden);
                    var vNodo=vDatatable.row.add(vArrayValores).draw(false);
                    $(vNodo.node()).attr('id',response[b][vIdPojo]);
                   
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

function fnGenerarDatatables(){
    var vCantidadCruds=$('input[name="cantidadCruds"]').val();
    fnModalXs('<div class="spinner offset-md-5"></div><p>Cargado informacion</p> ');
    for(var indice=0;indice<vCantidadCruds;indice++){
        fnListarGlobal(indice);
    }
    setTimeout(() => {
        swal.close();
        for(var indice2=0;indice2<vCantidadCruds;indice2++){
            $('button[id="btn-crud'+indice2+'"]').css('display','block');
        }
    }, 1000);
    
}
fnGenerarDatatables();
