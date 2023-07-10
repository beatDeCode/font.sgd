@for($indice=0;$indice< sizeof($vArregloParaOrden);$indice++ )
    <?php $vSeparacionStr=explode('|',$vArregloParaOrden[$indice]);?>
    <input type="hidden" name="{{$vSeparacionStr[0]}}" value="{{$vSeparacionStr[1]}}" >
@endfor