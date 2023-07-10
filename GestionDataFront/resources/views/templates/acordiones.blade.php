@for($indice=0;$indice< sizeof($vAcordiones) ; $indice++)
	<?php $vSeparacionStr=explode("|", $vAcordiones[$indice] ); ?>
	<div class="accordion" id="parent-{{$vSeparacionStr[2]}}">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="{{$vSeparacionStr[2]}}">
	      <button id="btn-{{$vSeparacionStr[2]}}" class="accordion-button collapsed" type="button" data-coreui-toggle="collapse" data-coreui-target="#col-{{$vSeparacionStr[2]}}" aria-expanded="false" aria-controls="col-{{$vSeparacionStr[2]}}">
	        <span class="badge bg-{{$vSeparacionStr[4]}}">#</span> <b> &nbsp;{{$vSeparacionStr[0]}} </b>
	      </button>
	    </h2>
	    <div id="col-{{$vSeparacionStr[2]}}" class="accordion-collapse collapse" aria-labelledby="{{$vSeparacionStr[2]}}" data-coreui-parent="#parent-{{$vSeparacionStr[2]}}">
	      <div class="accordion-body">
	      	<div class="row">
		        <div id="datatable1-{{$vSeparacionStr[3]}}" class="table-responsive col-md-{{$vSeparacionStr[5]}}"></div>
		        <div id="datatable2-{{$vSeparacionStr[3]}}" class="table-responsive col-md-{{$vSeparacionStr[6]}}"></div>
	        </div>
	        <div class="row">
		        <div id="adicional1-{{$vSeparacionStr[3]}}" class="table-responsive col-md-{{$vSeparacionStr[5]}}"></div>
		        <div id="adicional2-{{$vSeparacionStr[3]}}" class="table-responsive col-md-{{$vSeparacionStr[6]}}"></div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
	<br>

@endfor
