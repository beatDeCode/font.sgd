@include('admin-template.header')
@include('admin-template.sidebar')
@include('admin-template.navbar')
<div class="body flex-grow-1 px-3">
    <div class="container-xxl">
            <!-- [ Main Content ] start -->
        <div class="row">
        	@include('templates.apertura-card')
                <div style="font-size:14px;padding-left:10px;">
                    <li style="list-style: disclosure-closed;"><b>Búsqueda de Variables de la Campaña</b></li>
                        <br>
                    <div class="row">
                       
                        @include('templates.select-floating',['vColumnas'=>4,'vLabel'=>'Nivel de la Variable','vNombre'=>'nu_nivel','vOptions'=>$vOptionsNiveles])
                        <div class="col-md-2" style="padding-top:10px;">
                            <button class="btn btn-dark px-4" onclick="fnBuscarNiveles()">
                                Buscar
                            </button>
                        </div>
                       
                        @include('templates.input-disabled',['vTipoInput'=>'disabled','vColumnas'=>'1','vLabel'=>'Nivel de Variable','vNombre'=>'value','vValor'=>$vNivel])
                        @if(sizeOf($vVariableCierreContacto)>0)
                            @include('templates.select-con-valor',['vColumnas'=>3,'vLabel'=>'Variable de No Contactado','vNombre'=>'cd_variable_nc','vOptions'=>$vVariablesParaNC,'vValor'=>$vVariableCierreContacto[0]['value']])
                            <input type="hidden" name="cd_parametro" value="{{$vVariableCierreContacto[0]['text']}}">
                             <div class="col-md-1" style="padding-top:10px;">
                            <button class="btn btn-dark px-4" onclick="fnCambiarVariableDeNoContactado()">
                                Buscar
                            </button>
                        </div>
                        @endif
                        @if(sizeOf($vVariableCierreContacto)==0 && $vNivel!='$AL')
                            @include('templates.select-floating',['vColumnas'=>3,'vLabel'=>'Variable de Cierre','vNombre'=>'cd_variable_nc','vOptions'=>$vVariablesParaNC])
                             <div class="col-md-1" style="padding-top:10px;">
                            <button class="btn btn-dark px-4" onclick="fnCambiarVariableDeNoContactado()">
                                Buscar
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                <hr>
        		<form onsubmit="return false;" name="forms-variables" >
                    <div class="container-fluid">
            			<div class="row">
                            @if($vNivel!=1)
                                <?php $vOptionsAcciones=array();$vOptionsDecisionFinal=array(); ?>
                            @endif

                            @if( sizeof($vVariables)>0)
                                @foreach($vVariables as $vVariable)
                                    <input type="hidden" name="cd_variable" value="{{$vVariable['cd_variable']}}">
                                    <input type="hidden" name="nu_nivel" value="{{$vNivel}}">
                                    @include('templates.input-disabled',['vTipoInput'=>'disabled','vColumnas'=>'1','vLabel'=>'Cod.:','vNombre'=>'value','vValor'=>$vVariable['cd_variable']])
                                    @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>3,'vLabel'=>'Nombre','vNombre'=>'tx_variable','vValor'=>$vVariable['tx_variable']])
                                    @include('templates.select-con-valor',['vColumnas'=>1,'vLabel'=>'Depe.','vNombre'=>'in_dependencia','vOptions'=>$vOptionsDependencia,'vValor'=>$vVariable['in_dependencia']])
                                    @include('templates.select-con-valor',['vColumnas'=>3,'vLabel'=>'Relación','vNombre'=>'cd_relacion','vOptions'=>$vOptionsVariablesPadres,'vValor'=>$vVariable['cd_relacion']])
                                    @include('templates.select-con-valor',['vColumnas'=>2,'vLabel'=>'Acción','vNombre'=>'cd_accion','vOptions'=>$vOptionsAcciones,'vValor'=>$vVariable['cd_accion']])
                                    @include('templates.select-con-valor',['vColumnas'=>1,'vLabel'=>'Final','vNombre'=>'in_decision_final','vOptions'=>$vOptionsDecisionFinal,'vValor'=>$vVariable['in_decision_final']])
                                    <div class="col-md-1" style="padding-top:10px;"><a class="badge bg-info" 
                                        onclick="fnEliminar({{$vVariable['cd_variable']}},'{{$vVariable['tx_variable']}}',{{$vNivel}})" 
                                        style="font-size: 13px;color:white;font-weight: bolder;">Eliminar</a>
                                    </div>

                                @endforeach
                            @endif
                            @for($indice=0; $indice< 25- sizeof($vVariables) ; $indice++)
                                <input type="hidden" name="cd_variable" value="">
                                <input type="hidden" name="nu_nivel" value="{{$vNivel}}">
                                @include('templates.input-disabled',['vTipoInput'=>'disabled','vColumnas'=>'1','vLabel'=>'Cod.:','vNombre'=>'value','vValor'=>'var:x:'.$indice])
                                @include('templates.input',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Nombre','vNombre'=>'tx_variable'])
                                @include('templates.select-floating',['vColumnas'=>1,'vLabel'=>'Depe.','vNombre'=>'in_dependencia','vOptions'=>$vOptionsDependencia])
                                @include('templates.select-floating',['vColumnas'=>3,'vLabel'=>'Relacion','vNombre'=>'cd_relacion','vOptions'=>$vOptionsVariablesPadres])
                                @include('templates.select-floating',['vColumnas'=>2,'vLabel'=>'Acción','vNombre'=>'cd_accion','vOptions'=>$vOptionsAcciones])                            
                                @include('templates.select-floating',['vColumnas'=>1,'vLabel'=>'Final','vNombre'=>'in_decision_final','vOptions'=>$vOptionsDecisionFinal])
                                <div class="col-md-1"></div>
                            @endfor
                           
                            @csrf
                            <div class="col-md-12"> 
                                <center>
                                <br> <button class="btn btn-info btn-sm col-md-3" onclick="fnCargaVariables()" style="font-size: 14px;color:white;font-weight: bolder;">Cargar</button>
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