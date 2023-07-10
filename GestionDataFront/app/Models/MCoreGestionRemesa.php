<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;
use App\Models\MCoreGestionEmision;
use App\Models\MCoreVariablesCallCenter;
use Illuminate\Support\Facades\Http;
use Constantes;


class MCoreGestionRemesa extends Model{

    protected $table="coregestionremesa";
    protected $primaryKey='cd_gestion_remesa';
    public $timestamps = false;
    public $incrementing=false;

    protected $fillable=[
        "cd_proceso_campania",
        "in_existe_envio_correo",
        "in_existe_dominio",
        "in_actualizacion_nombre",
        "cd_usuario_actualizador",
        "correo_crudo",
        "nombre_crudo",
        "in_validanudocumento",
        "in_validaprimerapellido",
        "in_validaprimernombre",
        "tx_profesion",
        "nm_nombre1",
        "mt_ingreso",
        "nu_edad",
        "in_valida_telefono_local",
        "in_valida_fecha_nacimiento",
        "in_valida_telefono_movil",
        "in_valida_correo",
        "st_gestion_remesa",
        "cd_remesa",
        "in_ivss_validacion",
        "in_duplicado",
        "nu_telefono_hab",
        "fe_nacimiento",
        "nu_plazo_espera",
        "cd_asesor",
        "tp_cuenta",
        "nu_cuenta",
        "mt_suma_asegurada",
        "tx_correo",
        "tx_estado",
        "tx_ciudad",
        "tx_municipio",
        "tx_parroquia",
        "tx_apartamento",
        "tx_casa",
        "tx_urbanizacion",
        "calle",
        "nu_telefono",
        "tx_acteco",
        "tx_ocupacion",
        "tx_sexo",
        "tx_estado_civil",
        "tx_pais",
        "nu_documento",
        "tp_documento",
        "nm_nombre2",
        "nm_apellido2",
        "nm_apellido1",
        "cd_gestion_remesa",
        "nu_poliza",
        "in_valida_emision",
        "in_envio_solicitud_seguros",
        "cd_proceso_tecnico",
        "po_descuento_gestion"
    ];
    static function fnValidaciones(){
        return $validations=[
        "nm_nombre1"=> "required",
        "nm_apellido1"=> "required",
        "tp_documento"=> "required",
        "nu_documento"=> "required",
        "tx_correo"=> "required|email",
        "tx_sexo"=> "required",
        "tx_estado_civil"=> "required",
        "nu_telefono"=> "required"
     ];}

     static function fnMensajes(){
        return $validations=[
        "nm_nombre1.required"=> "El Campo es requerido",
        "nm_apellido1.required"=> "El Campo es requerido",
        "tp_documento.required"=> "El Campo es requerido",
        "nu_documento.required"=>"El Campo es requerido",
        "tx_correo.required"=> "El Campo es requerido",
        "tx_correo.email"=> "El valor debe ser con formato correo, ejemplo@dominio.com",
        "tx_sexo.required"=> "El Campo es requerido",
        "tx_estado_civil.required"=> "El Campo es requerido",
        "nu_telefono.required"=> "El Campo es requerido",
        "nu_telefono_hab.required"=> "El Campo es requerido"
        ];
    }

    public function fnModificar($request){
        $vRetornoOperacion='';
        try {
            $vBusquedaUpdate=$this->find(
                $request['cd_gestion_remesa']
            );
            $vBusquedaUpdate->nm_nombre1=$request['nm_nombre1'];
            $vBusquedaUpdate->nm_nombre2=$request['nm_nombre2'];
            $vBusquedaUpdate->nm_apellido1=$request['nm_apellido1'];
            $vBusquedaUpdate->nm_apellido2=$request['nm_apellido2'];
            $vBusquedaUpdate->in_validaprimernombre=1;
            $vBusquedaUpdate->in_validaprimerapellido=1;
            $vBusquedaUpdate->in_validanudocumento=1;
            $vBusquedaUpdate->in_valida_correo=1;
            $vBusquedaUpdate->in_valida_telefono_movil=1;
            $vBusquedaUpdate->in_valida_telefono_local=1;
            $vBusquedaUpdate->in_valida_fecha_nacimiento=1;
            $vBusquedaUpdate->in_actualizacion_nombre=99;
            $vBusquedaUpdate->save();
            $vRetornoOperacion='1';
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
    public function fnModificarFormularioEmision($request){
        $vRetornoOperacion='';
        $vValidarFormulario='';
        try {
            $vValidarFormulario = Validator::make(
                $request->all(),
                $this->fnValidaciones(),
                $this->fnMensajes()
            );
            if($vValidarFormulario->fails()){
                $vRetornoOperacion= $vValidarFormulario->errors();
            }else{
                $vDesgloseFecha=explode('-',$request->post('fe_nacimiento') );
                $vFechaNacimientoFormateada=$vDesgloseFecha[2].'-'.$vDesgloseFecha[1].'-'.$vDesgloseFecha[0];
                $request->request->add(['fe_nacimiento'=> $vFechaNacimientoFormateada ]);
                $this->where(
                    'cd_gestion_remesa', $request->post('cd_gestion_remesa')
                )->update($request->except(['_token','cd_gestion_remesa']));
                $vInstanciaGestionEmision=new MCoreGestionEmision;
                $vInstanciaGestionEmision->fnEliminarRegistros($request->post('cd_gestion_remesa'));
                $vRetornoOperacion='1';
            }
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }

    public function fnModificarFormularioCampania($request,$pNumeroAdicionales){
        $vRetornoOperacion='';
        $vValidarFormulario='';
        try {
            $vValidarFormulario = Validator::make(
                $request->all(),
                $this->fnValidaciones(),
                $this->fnMensajes()
            );

            if($vValidarFormulario->fails()){
                $vRetornoOperacion= $vValidarFormulario->errors();
            }else{
                $vCodigoGestionRemesa=$request->post('cd_gestion_remesa');
                $vInstanciaVariablesCallCenter= new MCoreVariablesCallCenter;
                $vVariable1=$request->post('cd_variable1');
                $vBuscarAccionVariable=$vInstanciaVariablesCallCenter->fnCustomQuery(array('cd_variable'=>$vVariable1),'vBuscarAccionVariable');
                if(sizeof($vBuscarAccionVariable)>0){
                    /*if($vBuscarAccionVariable[0]['cd_accion']==1){
                        //Emitir Correo
                        $vDatosDelUsuario=$vInstanciaVariablesCallCenter->fnCustomQuery(array('cd_gestion_remesa'=>$vCodigoGestionRemesa),'vBuscarDatosDeContactoDelCliente');
                        Http::post(Constantes::urlServicioCorreo, 
                            [
                                'txDireccionCorreo' => $vDatosDelUsuario[0]['tx_correo'],
                                'txAsuntoCorreo' => 'Número de telefono no Contactado, Seguros La Fe, C.A',
                                'txMensajeCuerpoCorreo'=>'<center><p>Estimado(a) <b>'.$vDatosDelUsuario[0]['nm_cliente'].'</b>,</p></center> 
                                    <p>Seguros La Fe C.A, le informa que hemos intentado contactarlo por v&iacutea telef&oacuta;nica, para ofrecerle xxx  </p>'
                            ]
                        );
                    }*/
                    if($vBuscarAccionVariable[0]['cd_accion']==2){
                        //Emitir Póliza
                        $this->where(
                            'cd_gestion_remesa', $vCodigoGestionRemesa
                        )->update(array('in_valida_emision'=>200));
                    }
                    if($vBuscarAccionVariable[0]['cd_accion']==2){
                        //Anular Poliza
                    }
                }
                $vDesgloseFecha=explode('-',$request->post('fe_nacimiento') );
                $vFechaNacimientoFormateada=$vDesgloseFecha[2].'-'.$vDesgloseFecha[1].'-'.$vDesgloseFecha[0];
                $request->request->add(['fe_nacimiento'=> $vFechaNacimientoFormateada ]);
                $vArrayException=['_token','cd_gestion_remesa','cd_campania','cd_variable0','cd_variable1','cd_variable2','cd_variable3','cd_variable4','cd_variable5','cd_variable6','cd_variable7','cd_grupo_familiar','cd_adicionales','cd_suma_asegurada','co_adicionales','co_suma_asegurada','co_grupo_familiar'];
                for($indice=0;$indice<$pNumeroAdicionales;$indice++){
                    array_push($vArrayException,'ad_tp_documento'.$indice);
                    array_push($vArrayException,'ad_nu_documento'.$indice);
                    array_push($vArrayException,'ad_nu_telefono'.$indice);
                    array_push($vArrayException,'ad_nu_area'.$indice);
                    array_push($vArrayException,'ad_cd_parentesco'.$indice);
                    array_push($vArrayException,'ad_fe_nacimiento'.$indice);
                }
                $this->where(
                    'cd_gestion_remesa', $vCodigoGestionRemesa
                )->update($request->except($vArrayException));
                $vRetornoOperacion='1';
            }
        } catch (Exception $ex) {
            
            $ex->getMessage();
        }
        return $vRetornoOperacion;
    }
}
