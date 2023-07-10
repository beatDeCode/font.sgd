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
                </div>
                    
                <hr>
        		<form onsubmit="return false;" name="remesa-carga" >
        			<div class="row">
	        			@include('templates.select-floating',['vColumnas'=>4,'vLabel'=>'Producto','vNombre'=>'cd_aliado','vOptions'=>$vOptionsAliadosPermitidos])
                        @include('templates.select-floating',['vColumnas'=>4,'vLabel'=>'Aliados','vNombre'=>'cd_producto','vOptions'=>$vOptionsProductosPermitidos])
	        			@include('templates.input-file',['vColumnas'=>4,'vLabel'=>'Carga de archivo','vNombre'=>'tx_archivo'])
                        @include('templates.inputs-orden',['vArregloParaOrden'=>$vArregloParaOrden])
                        @csrf
                        <center>
                            <div class="col-md-3"> 
                                <br> <button class="btn btn-info btn-sm col-md-12" onclick="fnCargarRemesa()" style="font-size: 14px;color:white;font-weight: bolder;">Cargar</button>
                            </div>
                        </center> 
					</div>
        		</form>

                <hr>
                <div class="badge bg-dark">Tabla Resumen</div>
                <hr>
                <div id="tabla-carga-remesa"></div>
        	@include('templates.cierre-card')
		</div>
        <!-- [ Main Content ] end -->
    </div>
</div>                 
@include('admin-template.footer')