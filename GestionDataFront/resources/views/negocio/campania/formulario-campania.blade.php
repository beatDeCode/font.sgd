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
                    <br>
                    <div class="row">
                        @include('templates.input',['vTipoInput'=>'text','vColumnas'=>3,'vLabel'=>'Número de Documento','vNombre'=>'nu_documento_aux'])
                        <div class="col-md-3" style="padding-top:10px;">
                            <button class="btn btn-dark px-4" onclick="fnBuscarCliente()">
                                Buscar Cliente
                            </button>
                        </div>
                        
                    </div>
                    <hr>
                </div>
                
        		<form onsubmit="return false;" name="forms-campania" >
                    <div class="container-fluid">
                        @if( sizeof($vClientes)>0)
                        
                            <div class="row">
                            
                            <div class="col-md-12">
                                <li style="list-style: disclosure-closed;font-size:14px;" ><b>Detalle del Contacto: ({{$vCantidadContactosPorDocumento[0]['valor']}}) veces contactado</b></li>
                                @foreach($vBuscarDetalleContactosClientePorDocumento as $vDetalle)
                                    <li style="list-style: disc;font-size:14px; margin-left: 10px;">{{$vDetalle['tx_contacto']}}</li>
                                @endforeach
                            </div>
                            </div>
                            <hr>
                            <li style="list-style: disclosure-closed;font-size:14px;" ><b>Formulario de Contacto</b></li>
                            <br>

                            <div class="row">
                                <?php $vInicial=0; ?>
                                @foreach($vClientes as $vCliente)
                                    @if( $vCliente['in_decision_final']==0)
                                        @if($vCliente['in_puede_revisar']==1)
                                            <input type="hidden" name="cd_gestion_remesa" value="{{$vCliente['cd_gestion_remesa']}}">
                                            <input type="hidden" name="cd_campania" value="{{$vCliente['cd_campania']}}">
                                            @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Primer Nombre','vNombre'=>'nm_nombre1','vValor'=>$vCliente['nm_nombre1']])
                                            @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Primer Apellido','vNombre'=>'nm_apellido1','vValor'=>$vCliente['nm_apellido1']])
                                            @include('templates.input-con-valor',['vTipoInput'=>'date','vColumnas'=>'3','vLabel'=>'Fecha de Nacimiento','vNombre'=>'fe_nacimiento','vValor'=>$vCliente['fe_nacimiento']])
                                            @include('templates.select-con-valor',['vColumnas'=>3,'vLabel'=>'Tipo de Documento','vNombre'=>'tp_documento','vOptions'=>$vOptionsTpDocumento,'vValor'=>$vCliente['tp_documento']])
                                            @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Documento','vNombre'=>'nu_documento','vValor'=>$vCliente['nu_documento']])
                                            @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Correo Electrónico','vNombre'=>'tx_correo','vValor'=>$vCliente['tx_correo']])
                                            @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Teléfono Móvil','vNombre'=>'nu_telefono','vValor'=>$vCliente['nu_telefono']])
                                            @include('templates.input-con-valor',['vTipoInput'=>'text','vColumnas'=>'3','vLabel'=>'Teléfono Local','vNombre'=>'nu_telefono_hab','vValor'=>$vCliente['nu_telefono_hab']])
                                            @include('templates.select-disabled',['vColumnas'=>3,'vLabel'=>'Suma Asegurada de Campaña','vNombre'=>'mt_suma_asegurada','vOptions'=>$vOptionsSumaAsegurada,'vValor'=>$vCliente['mt_suma_asegurada']])
                                            @include('templates.select-con-valor',['vColumnas'=>3,'vLabel'=>'Estado Civil','vNombre'=>'tx_estado_civil','vOptions'=>$vOptionsTpEstadoCivil,'vValor'=>$vCliente['tx_estado_civil']])
                                            @include('templates.select-con-valor',['vColumnas'=>3,'vLabel'=>'Sexo','vNombre'=>'tx_sexo','vOptions'=>$vOptionsTpSexo,'vValor'=>$vCliente['tx_sexo']])
                                        @elseif($vCliente['in_puede_revisar']==0)
                                            <?php $vInicial=1; ?>
                                            <center>El Sr(a). {{$vCliente['nm_nombre1']}} {{$vCliente['nm_apellido1']}} con documento {{$vCliente['nu_documento']}} , ya fue gestionado, debe esperar que se cierre el contacto de la campaña.</center>
                                            @endif
                                    @elseif($vCliente['in_decision_final']==1)
                                        <?php $vInicial=1; ?>
                                        <center>El Sr(a). {{$vCliente['nm_nombre1']}} {{$vCliente['nm_apellido1']}} con documento {{$vCliente['nu_documento']}}, posee una gestión con decision final.</center>
                                    @endif

                                @endforeach

                                @if(sizeOf($vClientes)>0 && $vInicial==1)
                                <div class="container-fluid">
                                    <hr>
                                </div>
                                <li style="list-style: disclosure-closed;font-size:14px;" ><b>Resumen de Contacto</b></li>
                                <div class="container-fluid">
                                    <br>
                                   <div class="container-fluid">
                                        <div class="row">
                                        @foreach($vDatosModificadosCliente as $vDatoModificadosCliente)
                                            <div class="col-md-3">
                                                <b>Nombre:</b> <br>
                                                {{$vDatoModificadosCliente['nm_nombre1']}}
                                            </div>
                                            <div class="col-md-3">
                                                <b>Apellido:</b> <br>
                                                {{$vDatoModificadosCliente['nm_apellido1']}}
                                            </div>
                                            <div class="col-md-3">
                                                <b>Fecha de Nacimiento:</b> <br>
                                                {{$vDatoModificadosCliente['fe_nacimiento']}}
                                            </div>
                                             <div class="col-md-3">
                                                <b>Tipo Documento:</b> <br>
                                                {{$vDatoModificadosCliente['tp_documento']}}
                                            </div>
                                            <div class="col-md-3">
                                                <b>Documento:</b> <br>
                                                {{$vDatoModificadosCliente['nu_documento']}}
                                            </div>
                                             <div class="col-md-3">
                                                <b>Correo:</b> <br>
                                                {{$vDatoModificadosCliente['tx_correo']}}
                                            </div>
                                            <div class="col-md-3">
                                                <b>Telefóno Móvil:</b> <br>
                                                {{$vDatoModificadosCliente['nu_telefono']}}
                                            </div>
                                            <div class="col-md-3">
                                                <b>Telefono Habitacíon:</b> <br>
                                                {{$vDatoModificadosCliente['nu_telefono_hab']}}
                                            </div>
                                            <div class="col-md-3">
                                                <b>Suma Asegurada:</b> <br>
                                                {{$vDatoModificadosCliente['nu_telefono']}}
                                            </div>
                                            <div class="col-md-3">
                                                <b>Estado Civil:</b> <br>
                                                {{$vDatoModificadosCliente['nu_telefono_hab']}}
                                            </div>
                                            <div class="col-md-3">
                                                <b>Sexo: </b><br>
                                                {{$vDatoModificadosCliente['tx_sexo']}}
                                            </div>
                                        @endforeach
                                        </div>
                                        
                                    </div> 
                                    <br>
                                    @if(sizeOf($vAdicionalesPorDocumento)>0)
                                            <li style="list-style: disclosure-closed;font-size:14px;" ><b>Familiares</b></li>
                                            <br>
                                            <table style="font-size: 14px;" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Parentesco</th>
                                                        <th>Tipo Documento</th>
                                                        <th>Documento</th>
                                                        <th>Área Telefono</th>
                                                        <th>Telefono</th>
                                                        <th>Fecha de Nacimiento</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($vAdicionalesPorDocumento as $vAdicionalPorDocumento)
                                                        <tr>
                                                            <td>{{$vAdicionalPorDocumento['parentesco']}}</td>
                                                            <td>{{$vAdicionalPorDocumento['tp_documento']}}</td>
                                                            <td>{{$vAdicionalPorDocumento['nu_documento']}}</td>
                                                            <td>{{$vAdicionalPorDocumento['nu_area']}}</td>
                                                            <td>{{$vAdicionalPorDocumento['nu_telefono']}}</td>
                                                            <td>{{$vAdicionalPorDocumento['fe_nacimiento']}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                        @endif
                                    @endif
                                    <hr>

                                </div>
                                
                                @csrf
                            </div>
                            @if($vClientes[0]['in_decision_final']==0 && $vCliente['in_puede_revisar']==1)
                                <li style="list-style: disclosure-closed;font-size:14px;" ><b>Variables del Contacto</b></li>
                                <br>
                                <div class="row">
                                    
                                    @foreach($vNiveles as $vNivel)
                                        <?php $vArrayVariables=[]; ?>
                                        <?php $vContador=0; ?>
                                        <?php $vContadorRelaciones=0; ?>
                                        @for($indice=0;$indice< sizeof($vVariables) ;$indice++)
                                            
                                            @if($vVariables[$indice]['nu_nivel']==$vNivel['nu_nivel'])
                                                @if($vVariables[$indice]['cd_relacion']==null)
                                                    <?php $vContadorRelaciones+=1; ?>
                                                @endif
                                                <?php $vArrayVariables[$vContador]=$vVariables[$indice];?>
                                                <?php $vContador+=1; ?>
                                            @endif
                                            
                                            
                                        @endfor

                                        <?php $vContador=0; ?>
                                        <?php 
                                            $vVariable='cd_variable'.$vNivel['nu_nivel']; 
                                            $vNivelForm=$vNivel['nu_nivel'];
                                            $vNombreForm=$vNivel['tx_variable']; ?>
                                        @if($vNivel['nu_nivel']==0)
                                                @include('templates.select-floating-fun',['vColumnas'=>4,'vLabel'=>$vNivel['tx_variable'],'vNombre'=>'cd_variable'.$vNivelForm,'vOptions'=>$vArrayVariables,'vFuncion'=>'fnBuscarHijos('.$vNivelForm.')', 'vStyle'=>''])
                                        @endif
                                        @if($vNivel['nu_nivel']!=0)
                                                @include('templates.select-floating-fun',['vColumnas'=>4,'vLabel'=>$vNivel['tx_variable'],'vNombre'=>'cd_variable'.$vNivelForm,'vOptions'=>array(),'vFuncion'=>'fnBuscarHijos('.$vNivelForm.')','vStyle'=>'display:none;'])
                                            
                                        @endif
                                        
                                    @endforeach
                                    <div id="div-formulario-tecnico"  style="display:none;">
                                        @include('templates.select-floating-fun',['vColumnas'=>4,'vLabel'=>'Grupo Familiar','vNombre'=>'co_grupo_familiar','vOptions'=>$vGruposFamiliares,'vFuncion'=>'fnBuscarSumasAseguradas()','vStyle'=>'padding-left:11px;padding-right:11px;'])
                                        
                                    </div>
                                    <div id="div-formulario-sumas" class="col-md-4"></div>
                                    <div id="div-formulario-adicionales" class="col-md-4"></div>
                                    
                                </div>
                                
                                <div id="div-formulario-familiares" class="row">


                                </div>
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <center>
                                        <br> <button class="btn btn-info btn-sm col-md-3" onclick="fnCargaContacto()" style="font-size: 14px;color:white;font-weight: bolder;">Cargar</button>
                                        </center>
                                    </div>
                                </div>
                            @endif
                            
                        @endif
                    </div>
        		</form>
                <input type="hidden" name="contador" value="0">
        	@include('templates.cierre-card')
		</div>
        <!-- [ Main Content ] end -->
    </div>
</div>                 
@include('admin-template.footer')