<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class MCoreUsuarios extends Model{
    protected $table="coreusuario";
    protected $attributes  =['st_usuario'=>1, 'cd_app'=>1];
    protected $primaryKey='cd_usuario';
    public $timestamps = false;
    public $incrementing=false;
    protected $fillable=["tx_correo","nm_usuario","st_usuario","cd_app","fe_registro","tx_clave","cd_usuario"];
    static function fnValidaciones(){
        return $validations=["cd_usuario"=> "required|unique:coreusuario,cd_usuario",
         "nm_usuario"=> "required",
         "tx_correo"=> "required|email"
     ];}

    static function fnMensajes(){
        return $validations=[
        "tx_correo.required"=> "El Campo es requerido.",
        "tx_correo.email"=> "El valor debe ser con formato correo, ejemplo@dominio.com",
        "nm_usuario.required"=> "El Campo es requerido",
        "cd_usuario.required"=> "El Campo es requerido",
        "cd_usuario.unique"=> "El valor introducido ya existe",
        ];
    }
    static function fnValidacionesUpd(){
        return $validations=[
            "cd_usuario"=> "required",
         "nm_usuario"=> "required",
         "tx_correo"=> "required|email"
     ];}

    static function fnMensajesUpd(){
        return $validations=[
        "tx_correo.required"=> "El Campo es requerido.",
        "tx_correo.email"=> "El valor debe ser con formato correo, ejemplo@dominio.com",
        "nm_usuario.required"=> "El Campo es requerido",
        "cd_usuario.required"=> "El Campo es requerido",
        ];
    }
    public function fnListar(){
        $vTransaccion='';
        try {
            $vTransaccion=DB::select(
                "SELECT 
                    lower(cd_usuario)cd_usuario,
                    nm_usuario,
                    tx_correo,
                    (SELECT 
                        (select tx_rol from coreroles coro where  coro.cd_rol=rous.cd_rol) 
                    FROM coreusuariosrol rous 
                    where rous.cd_usuario=usua.cd_usuario and cd_app=1) tx_rol,
                    (SELECT 
                        rous.cd_rol 
                    FROM coreusuariosrol rous 
                    where rous.cd_usuario=usua.cd_usuario and cd_app=1) cd_rol,
                    st_usuario,
                    0 st_eliminar
                FROM coreusuario usua
                where cd_app=1");
            $vTransaccion=array_map(function($valor){
                if($valor->st_usuario==1){ 
                    $valor->st_usuario='<span class="badge me-1 bg-success">Activo</span>';
                }else{
                    $valor->st_usuario='<span class="badge me-1 bg-danger">Inactivo</span>';
                }
                return (array)$valor;
            }, $vTransaccion);
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }

    public function fnListarPorId($pId){
        $vTransaccion='';
        try {
            $vBusqueda=
            'SELECT 
                cd_usuario,
                nm_usuario,
                tx_correo,
                (SELECT 
                    cd_rol 
                FROM coreusuariosrol rous 
                where rous.cd_usuario=usua.cd_usuario and cd_app=1) cd_rol,
                st_usuario
            FROM coreusuario usua
            where cd_app=1
            and cd_usuario=upper(?)';
            $vTransaccion=DB::select($vBusqueda,[$pId]);
            $vTransaccion=array_map(function($valor){
                return (array)$valor;
            }, $vTransaccion);
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vTransaccion;
    }

    public function fnAgregar($request){
        $vRetornoOperacion=0;
        try {
            $vCdUsuario=trim(strtoupper($request->post('cd_usuario')),' ');
            $vNmUsuario=ucfirst(strtoupper($request->post('nm_usuario')) );
            $vTxCorreo=ucfirst(strtoupper($request->post('tx_correo')) );
            $request->request->add(['cd_usuario'=>$vCdUsuario]);
            $request->request->add(['nm_usuario'=> $vNmUsuario]);
            $vValidarFormulario = Validator::make(
                $request->all(),
                $this->fnValidaciones(),
                $this->fnMensajes()
            );
            if($vValidarFormulario->fails()){
                $vRetornoOperacion= $vValidarFormulario->errors();
            }else{
                $vClave=$this->fnGenerarClave();
                $vSeparacionStr=explode('|', $vClave);
                $request->request->add(['fe_registro'=> Carbon::now()->format('Y-m-d')]);
                $request->request->add(['tx_clave'=> $vSeparacionStr[0]]);
                
                $vRetornoInsercion=$this->create(
                    $request->except(['_token_md','nombreController_cd','cd_rol'])
                );
                $vRoles=array('cd_usuario'=>$vCdUsuario,
                'cd_rol'=>strtoupper($request->post('cd_rol')) );
                $vInstanciaRoles=new MCoreUsuariosRol;
                $vInstanciaRoles->fnAgregar($vRoles);
                Http::post('http://localhost:8081/sgd.envio-correo', 
                    [
                        'txDireccionCorreo' => $vTxCorreo,
                        'txAsuntoCorreo' => 'Credenciales para Inicio de Sesión al Sistema Gestion Data (SGD).',
                        'txMensajeCuerpoCorreo'=>'<p>Estimado <b>'.$vNmUsuario.'</b>,</p> 
                            <p>Nos complace informarle que su clave ha sido creada con &eacute;xito, desde ahora podr&aacute; iniciar sesi&ooacute; con, </p>'.
                            '<center>Usuario: <b><h2>'.$vCdUsuario.'<h2></b>
                            Contrase&ntilde;a es : <b></h2>'.$vSeparacionStr[1].'<h2></b></center>'
                    ]
                );
                $vRetornoOperacion='1';
            }
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }

    public function fnGenerarClave(){
        $vValorAlfabetico=array('SGD','SG','GESTION','DATA');
        $vCaracterEspecial=array('#','$','&','+','-','!','.',':');
        $vValorNumerico=rand(1000,9999);
        $vClaveGenerada=$vValorAlfabetico[rand(1,(sizeof($vValorAlfabetico)-1))].''.
        $vCaracterEspecial[rand(1,(sizeof($vCaracterEspecial)-1))].''.
        $vValorNumerico;
        return sha1($vClaveGenerada).'|'.$vClaveGenerada;
    }
    public function fnCambioClave($request){
        $vRetornoOperacion=0;
        try {
            $vCdUsuario=trim(strtoupper($request->post('cd_usuario')),' ');
            $vTxCorreo=trim(strtolower($request->post('tx_correo')),' ');
            $vDatosDelUsuario=$this->fnListarPorId($vCdUsuario);

            if(sizeof($vDatosDelUsuario)>0){
                $vClave=$this->fnGenerarClave();
                $vSeparacionStr=explode('|', $vClave);

                $request->request->add(['cd_usuario'=> $vCdUsuario]);
                $request->request->add(['tx_correo'=> $vTxCorreo]);
                $vRetornoInsercion=$this->where(
                        $request->except(['_token'])
                    )->update(array('tx_clave'=>  $vSeparacionStr[0] ));
                
                Http::post('http://10.10.0.202:8081/sgd.envio-correo', 
                    [
                        'txDireccionCorreo' => $vDatosDelUsuario[0]['tx_correo'],
                        'txAsuntoCorreo' => 'Recuperación de Contraseña Sistema Gestion Data (SGD).',
                        'txMensajeCuerpoCorreo'=>'<center><p>Estimado(a) <b>'.$vDatosDelUsuario[0]['nm_usuario'].'</b>,</p></center> 
                            <p>Nos complace informarle que su clave se cambi&oacute; con &eacute;xito, desde este momento podr&aacute; iniciar sesi&ooacute con ,'.
                        '<center>contrase&ntilde;a : <b></h2>'.$vSeparacionStr[1].'<h2></b></center>'
                    ]
                );
                $vRetornoOperacion=99999999;
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
    function fnActualizar($request){
        $vRetornoOperacion=0;
        try {

            $vValidarFormulario = Validator::make(
                $request->all(),
                $this->fnValidacionesUpd(),
                $this->fnMensajesUpd()
            );
            if($vValidarFormulario->fails()){
               $vRetornoOperacion= $vValidarFormulario->errors();
            }else{
                $vRetornoInsercion=$this->where(
                    array('cd_usuario'=>$request->post('cd_usuario'))
                )->update($request->except(['_token_md','nombreController_cd',"cd_usuario","cd_rol"]));
                $vInstanciaRoles=new MCoreUsuariosRol;
                $vInstanciaRoles->fnActualizar($request->post('cd_usuario'),$request->post('cd_rol'));
                $vRetornoOperacion=1;

            }
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }


}
