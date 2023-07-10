@include('admin-template.header')
@include('admin-template.sidebar')
@include('admin-template.navbar')
<div class="body flex-grow-1 px-3">
    <div class="container-xxl">
            <!-- [ Main Content ] start -->
        <div class="row">
        	@include('templates.apertura-card')
                <div style="font-size:14px;padding-left:10px;">
                    <li style="list-style: disclosure-closed;"><b>Formulario de Búsqueda</b></li>
                        <br>
                    <div class="row">
                        @include('templates.select-floating',['vColumnas'=>6,'vLabel'=>'Remesa','vNombre'=>'cd_remesa','vOptions'=>$vOptionsRemesas])
                        <div class="col-md-2" style="padding-top:10px;">
                            <button class="btn btn-dark px-4" onclick="fnBuscarNombresCompuestos()">
                                Buscar
                            </button>
                        </div>
                        @if($vCdRemesa)
                            @include('templates.input-disabled',['vTipoInput'=>'disabled','vColumnas'=>'4','vLabel'=>'Código de la Remesa','vNombre'=>'value','vValor'=>'Remesa # '.$vCdRemesa])
                        @endif
                    </div>
                </div>
                
                <hr>
                <input type="hidden" name="cd_aliado_xs" value="{{$vCdRemesa}}">
        		<form onsubmit="return false;" name="forms-nombres-compuestos">
                    <div class="container-fluid">
            			<div class="row">
                            @if( sizeof($vNombresCompuestos)>0)
                                @foreach($vNombresCompuestos as $vNombre)
                                    <input type="hidden" value="{{$vNombre['cd_gestion_remesa']}}" name="cd_gestion_remesa-{{$vNombre['cd_gestion_remesa']}}">
                                    <input type="hidden" value="{{$vNombre['nombre_crudo']}}" name="nombre_crudo-{{$vNombre['cd_gestion_remesa']}}">
                                    <div class="col-md-4" style="padding-top:10px;">
                                        <p>{{$vNombre['nombre_crudo']}}</p>
                                    </div>
                                    @include('templates.input',['vTipoInput'=>'text','vColumnas'=>2,'vLabel'=>'Primer Nombre','vNombre'=>'nm_nombre1'])
                                    @include('templates.input',['vTipoInput'=>'text','vColumnas'=>2,'vLabel'=>'Segundo Nombre','vNombre'=>'nm_nombre2'])
                                    @include('templates.input',['vTipoInput'=>'text','vColumnas'=>2,'vLabel'=>'Primer Apellido','vNombre'=>'nm_apellido1'])
                                    @include('templates.input',['vTipoInput'=>'text','vColumnas'=>2,'vLabel'=>'Segundo Apellido','vNombre'=>'nm_apellido2'])
                                @endforeach
                            @endif
                           
                            @csrf
                            <div class="col-md-12"> 
                                <center>
                                <br> <button class="btn btn-info btn-sm col-md-3" onclick="fnCargarNombresCompuestos()" style="font-size: 14px;color:white;font-weight: bolder;">Cargar</button>
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