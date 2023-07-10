@include('admin-template.header')
@include('admin-template.sidebar')
@include('admin-template.navbar')
<div class="body flex-grow-1 px-3">
    <div class="container-xxl">
            <!-- [ Main Content ] start -->
        <div class="row">
        	@include('templates.apertura-card')
                <div style="font-size:14px;padding-left:10px;" class="container-fluid">
                    <li style="list-style: disclosure-closed;"><b>Formulario de Búsqueda</b></li>
                    <hr>
                    <div class="row">
                        @include('templates.input',['vTipoInput'=>'text','vColumnas'=>3,'vLabel'=>'Número de Documento','vNombre'=>'nu_documento'])
                        <div class="col-md-3" style="padding-top:10px;">
                            <button class="btn btn-dark px-4" onclick="fnBuscarCliente()">
                                Buscar Cliente
                            </button>
                        </div>
                        
                    </div>
                </div>
                <div class="container-fluid">
                    @if(sizeof($vErroresPorClientes)>0)
                        <li style="list-style: disclosure-closed;font-size:14px;" ><b>Errores en la Emisión del documento </b></li>
                        <hr>
                        <div class="container-fluid">
                            @foreach($vErroresPorClientes as $vError)
                                <li style="list-style:initial;font-size:14px;" >{{$vError['tx_mensaje']}}</li>
                            @endforeach
                        </div>
                    @endif
                </div>
                <hr>
        		<form onsubmit="return false;" name="forms-errores-emision" >
                    <div class="container-fluid">
                        @if( sizeof($vClientes)>0)
                            <li style="list-style: disclosure-closed;font-size:14px;" ><b>Formulario de Gestion</b></li>
                            <hr>
                            <div class="row">
                                @foreach($vClientes as $vCliente)
                                    <input type="hidden" name="cd_gestion_remesa" value="{{$vCliente['cd_gestion_remesa']}}">
                                    @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Primer Nombre','vNombre'=>'nm_nombre1','vValor'=>$vCliente['nm_nombre1']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Primer Apellido','vNombre'=>'nm_apellido1','vValor'=>$vCliente['nm_apellido1']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'date','vColumnas'=>'3','vLabel'=>'Fecha de Nacimiento','vNombre'=>'fe_nacimiento','vValor'=>$vCliente['fe_nacimiento']])
                                    @include('templates.select-con-valor',['vColumnas'=>3,'vLabel'=>'Tipo de Documento','vNombre'=>'tp_documento','vOptions'=>$vOptionsTpDocumento,'vValor'=>$vCliente['tp_documento']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Número de Documento','vNombre'=>'nu_documento','vValor'=>$vCliente['nu_documento']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Correo Electrónico','vNombre'=>'tx_correo','vValor'=>$vCliente['tx_correo']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Teléfono Móvil','vNombre'=>'nu_telefono','vValor'=>$vCliente['nu_telefono']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Teléfono Local','vNombre'=>'nu_telefono_hab','vValor'=>$vCliente['nu_telefono_hab']])
                                    @include('templates.select-con-valor',['vColumnas'=>3,'vLabel'=>'Sexo','vNombre'=>'tx_sexo','vOptions'=>$vOptionsTpSexo,'vValor'=>$vCliente['tx_sexo']])
                                    @include('templates.select-con-valor',['vColumnas'=>3,'vLabel'=>'Estado Civil','vNombre'=>'tx_estado_civil','vOptions'=>$vOptionsTpEstadoCivil,'vValor'=>$vCliente['tx_estado_civil']])
                                @endforeach
                                @csrf
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12"> 
                                <center>
                                <br> <button class="btn btn-info btn-sm col-md-3" onclick="fnProcesarError()" style="font-size: 14px;color:white;font-weight: bolder;">Cargar</button>
                                </center>
                            </div>
                        </div>
                    </div>
        		</form>
        	@include('templates.cierre-card')
		</div>
        <!-- [ Main Content ] end -->
    </div>
</div>                 
@include('admin-template.footer')