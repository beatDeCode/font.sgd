<div class="col-md-{{$vColumnas}}">
	<div class="form-floating">
	  <select class="form-select" name="{{$vNombre}}" id="floatingSelect" aria-label="Select" >
	    <option></option>
	    @for($indice=0;$indice < sizeof($vOptions);$indice++)
			@if($vOptions[$indice]['value']==$vValor)
	    		<option value="{{$vOptions[$indice]['value']}}" selected="selected">{{$vOptions[$indice]['text']}}</option>
			@endif
			@if($vOptions[$indice]['value']!=$vValor)
				<option value="{{$vOptions[$indice]['value']}}">{{$vOptions[$indice]['text']}}</option>
			@endif
	    @endfor
	  </select>
	  <label for="floatingSelect" id="{{$vNombre}}">{{$vLabel}}</label>
	</div>
	<center><p style="font-size:12px;color:red" id="{{$vNombre}}"></p></center>
</div>