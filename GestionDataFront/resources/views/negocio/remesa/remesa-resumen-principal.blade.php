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
                    <hr>
                </div>
            <div class="row">
                @include('templates.select-floating',['vColumnas'=>6,'vLabel'=>'Código de la remesa','vNombre'=>'cd_remesa','vOptions'=>$vOptionsRemesas])
                @include('templates.button',['vNombre'=>'Buscar Remesa','vColor'=>'dark','vColumnas'=>2,'vFuncionJS'=>'fnBuscarRemesa'])
            </div>
            <hr>
            <div style="font-size:14px;padding-left:10px;display:none;" id="2">
            <li style="list-style: disclosure-closed;"><b>Detalle de la Remesa</b></li>
                    <hr>
            </div>
            <div class="container-fluid">
                <div class="row" id="detalle-remesa"></div>
                <hr>
            </div>
            <div style="display:none;" id="panel-remesa">
                @include('templates.acordiones',['vAcordiones'=> $vAcordiones])
        	   @include('templates.cierre-card')
            </div>
		</div>
        <!-- [ Main Content ] end -->
    </div>
</div>                 
@include('admin-template.footer')