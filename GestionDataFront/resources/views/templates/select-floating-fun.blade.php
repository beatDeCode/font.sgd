<div class="col-md-{{$vColumnas}}">
	<div class="form-floating" id="{{$vNombre}}" style="{{$vStyle}}" >
	  <select class="form-select" name="{{$vNombre}}" id="floatingSelect" aria-label="Select" onchange="{{$vFuncion}}" >
	    <option selected></option>
	    @for($indice=0;$indice < sizeof($vOptions);$indice++)
	    	<option value="{{$vOptions[$indice]['value']}}">{{$vOptions[$indice]['text']}}</option>
	    @endfor
	  </select>
	  <label for="floatingSelect" id="{{$vNombre}}">{{$vLabel}}</label>
	</div>
	<center><p style="font-size:12px;color:red" id="{{$vNombre}}"></p></center>
</div> 