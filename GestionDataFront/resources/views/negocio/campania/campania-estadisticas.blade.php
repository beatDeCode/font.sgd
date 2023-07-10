@include('admin-template.header')
@include('admin-template.sidebar')
@include('admin-template.navbar')
<div class="body flex-grow-1 px-3">
    <div class="container-xxl">
            <!-- [ Main Content ] start -->
        <div class="row">
            
        	@include('templates.apertura-card')
            <div style="font-size:14px;padding-left:10px;">
                    <li style="list-style: disclosure-closed;"><b>Estadísticas de la Campania</b></li>
                    <hr>
                </div>
            <div class="row">
                @include('templates.select-floating-fun',['vColumnas'=>4,'vLabel'=>'Código de la Campaña','vNombre'=>'cd_remesa','vStyle'=>'display:block;','vOptions'=>$vOptionsRemesas,'vFuncion'=>'fnBuscarCampaniasPorRemesa()'])
                 <div class="col-md-6" id="div-select"></div>
                @include('templates.button',['vNombre'=>'Buscar Campania','vColor'=>'dark','vColumnas'=>2,'vFuncionJS'=>'fnGenerarPrimerosCuadros'])
            </div>
            <hr>
            <div style="font-size:14px;padding-left:10px;" id="2">
            <li style="list-style: disclosure-closed;"><b>Graficos</b></li>
                <p id="aFecha"></p>
                <div class="row">
                    <div class="col-md-6" >
                        <div class="chart-container" style="width: 100%;" id="cjgrafico00">

                        </div>
                        
                    </div>
                    <div class="col-md-6" >
                        <div id="tbgrafico00" >

                        </div>
                    </div>
                    <hr>
                    <div class="col-md-6" >
                        <div class="chart-container" style="width: 100%;" id="cjgrafico10">

                        </div>
                        
                    </div>
                    <div class="col-md-6" >
                        <div id="tbgrafico10" >

                        </div>
                    </div>
                    <hr> 
                    <div class="col-md-6">

                        <div style="display:none;" id="div-select-grafico-2">@include('templates.select-floating-fun',['vColumnas'=>12,'vLabel'=>'Variable de Gestión','vNombre'=>'cd_variable','vStyle'=>'display:block;','vOptions'=>$vOptionsVariables,'vFuncion'=>'fnGenerarGraficoPorUsuarios()'])
                        </div>
                        <div id="cjgrafico20" class="chart-container" style="width: 100%;"></div>
                    </div>
                   

                    <div class="col-md-6" >
                        <div id="tbgrafico20" >

                        </div>
                    </div>

                    <hr> 

                    <div class="col-md-6">

                        <div style="display:none;" id="div-select-grafico-3">@include('templates.select-floating-fun',['vColumnas'=>12,'vLabel'=>'Número de Contacto','vNombre'=>'nu_nivel','vStyle'=>'display:block;','vOptions'=>$vOptionsNiveles,'vFuncion'=>'fnGenerarGraficoPorNumeroConsecutivo()'])
                        </div>
                        <div id="cjgrafico30" class="chart-container" style="width: 100%;"></div>
                    </div>
                   

                    <div class="col-md-6" >
                        <div id="tbgrafico30" >

                        </div>
                    </div>

                    <input type="hidden" name="input-switch">
                    
                </div>
            <hr>
            </div>
            
            
        	@include('templates.cierre-card')
           
		</div>
        <!-- [ Main Content ] end -->
    </div>
</div>                 
@include('admin-template.footer')