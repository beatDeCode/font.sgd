@include('admin-template.header')
@include('admin-template.sidebar')
@include('admin-template.navbar')
<div class="body flex-grow-1 px-3">
    <div class="container-xxl">
            <!-- [ Main Content ] start -->
        <div class="row">
        	@include('templates.apertura-card')
                <div style="font-size:14px;padding-left:10px;">
                    <li style="list-style: disclosure-closed;"><b>Formulario de Carga</b></li>
                        <br>
                    <div class="row">
                        @include('templates.select-floating',['vColumnas'=>4,'vLabel'=>'Aliado Comercial','vNombre'=>'cd_aliado','vOptions'=>$vOptionsAliadosPermitidos])
                        <div class="col-md-3" style="padding-top:10px;">
                            <button class="btn btn-dark px-4" onclick="fnBuscarRangoAliado()">
                                Buscar
                            </button>
                        </div>
                        @if($vNombreAliado)
                            @include('templates.input-disabled',['vTipoInput'=>'disabled','vColumnas'=>'5','vLabel'=>'Aliado Comercial','vNombre'=>'value','vValor'=>$vNombreAliado])
                        @endif
                    </div>
                </div>
                
                <hr>
                <input type="hidden" name="cd_aliado_xs" value="{{$vCdAliado}}">
        		<form onsubmit="return false;" name="forms-rango-edades" >
                    <div class="container-fluid">
            			<div class="row">
                            @if( sizeof($vRangosEdad)>0)
                                @foreach($vRangosEdad as $vRango)
                                    @include('templates.input-con-valor',['vTipoInput'=>'hidden','vColumnas'=>4,'vLabel'=>'','vNombre'=>'cd_aliado','vValor'=>$vRango['cd_aliado']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'hidden','vColumnas'=>4,'vLabel'=>'','vNombre'=>'cd_edad','vValor'=>$vRango['cd_edad']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'hidden','vColumnas'=>4,'vLabel'=>'','vNombre'=>'cd_rango_edad','vValor'=>$vRango['cd_rango_edad']])
                                    @include('templates.input-disabled',['vTipoInput'=>'disabled','vColumnas'=>'4','vLabel'=>'Código Parametro #:','vNombre'=>'value','vValor'=>$vRango['cd_rango_edad']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'number','vColumnas'=>'3','vLabel'=>'Edad Mínima','vNombre'=>'min_edad'.$vRango['cd_rango_edad'],'vValor'=>$vRango['min_edad']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'number','vColumnas'=>'3','vLabel'=>'Edad Máxima','vNombre'=>'max_edad'.$vRango['cd_rango_edad'],'vValor'=>$vRango['max_edad']])
                                    <div class="col-md-2" style="padding-top:10px;"><a class="badge bg-info" 
                                        onclick="fnEliminar( {{$vRango['cd_rango_edad']}}, {{$vCdAliado}}, {{$vRango['min_edad']}}, {{$vRango['max_edad']}} ) " 
                                        style="font-size: 13px;color:white;font-weight: bolder;">Eliminar</a>
                                    </div>
                                    
                                @endforeach
                            @endif
                            @for($indice=0; $indice< 10- sizeof($vRangosEdad) ; $indice++)
                                @include('templates.input-con-valor',['vTipoInput'=>'hidden','vColumnas'=>4,'vLabel'=>'','vNombre'=>'cd_aliado','vValor'=>$vCdAliado])
                                @include('templates.input',['vTipoInput'=>'hidden','vColumnas'=>4,'vLabel'=>'','vNombre'=>'cd_edad'])
                                @include('templates.input',['vTipoInput'=>'hidden','vColumnas'=>4,'vLabel'=>'','vNombre'=>'cd_rango_edad'])
                                @include('templates.input-disabled',['vTipoInput'=>'disabled','vColumnas'=>'4','vLabel'=>'Código Parametro #:','vNombre'=>'value','vValor'=>'var:x:'.$indice])
                                @include('templates.input',['vTipoInput'=>'number','vColumnas'=>'3','vLabel'=>'Edad Mínima','vNombre'=>'min_edad'.$indice])
                                @include('templates.input',['vTipoInput'=>'number','vColumnas'=>'3 ','vLabel'=>'Edad Máxima','vNombre'=>'max_edad'.$indice])
                                <div class="col-md-2">
                                </div>

                            @endfor
                           
                            @csrf
                            <div class="col-md-12"> 
                                <center>
                                <br> <button class="btn btn-info btn-sm col-md-3" onclick="fnCargaRangoEdades()" style="font-size: 14px;color:white;font-weight: bolder;">Cargar</button>
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