@include('admin-template.header')
@include('admin-template.sidebar')
@include('admin-template.navbar')
<div class="body flex-grow-1 px-3">
    <div class="container-xxl">
            <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ badge ] start -->
            @if(sizeof($pCruds)>0)
                <input type="hidden" name="cantidadCruds" value="{{sizeof($pCruds)}}" >
                @for($indice=0;$indice< sizeof($pCruds) ;$indice++)
                <?php  $vSeparacionStr= explode('|',$pCruds[$indice]); ?>
                <div class="col-sm-{{$vSeparacionStr[4]}}">
                    <div class="card mb-4" >
                        <div class="badge bg-dark">
                            <h6>{{$vSeparacionStr[0]}}</h6>
                        </div>
                        <div class="card-body">
                            </div>
                            <input type="hidden" name="nombreController{{$indice}}" value="{{$vSeparacionStr[1]}}" >
                            <input type="hidden" name="funcionController{{$indice}}" value="{{$vSeparacionStr[3]}}">
                            <input type="hidden" name="nombreEtiqueta{{$indice}}" value="{{$vSeparacionStr[0]}}">
                            <input type="hidden" name="rutaControlador{{$indice}}" value="{{$vSeparacionStr[5]}}">
                            @csrf
                            <div class="container-fluid" id="modal-agregar-launch{{$indice}}"></div>
                            <center>
                                <button class="btn btn-info" id="btn-crud{{$indice}}"
                                        style="font-size:14px;color:white;font-weight:bold;display:none;" 
                                        onclick="fnModalAgregar('{{$indice}}','{{$vSeparacionStr[2]}}')">
                                            Registrar Data
                                </button>
                            </center>
                            <div class="container-fluid" id="datatable-listar{{$indice}}"></div>
                        </div>
                    </div>
                
                @endfor
            </div>
            
            
            @endif
            <!-- [ badge ] end -->
            <div class="container-fluid" id="modal-sesion-launch{{$indice}}"></div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
                    
@include('admin-template.footer')