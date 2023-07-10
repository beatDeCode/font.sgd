package com.ve.gestiondata.mailcore.repos;

import java.util.List;

import javax.transaction.Transactional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import com.ve.gestiondata.mailcore.pojos.CoreGestionRemesa;



public interface CoreGestionRemesaRepo extends JpaRepository<CoreGestionRemesa, Long> {

	@Query(value="SELECT CD_GESTION_REMESA,NM_APELLIDO1,NM_APELLIDO2,NM_NOMBRE1,"
			+ "NM_NOMBRE2,TP_DOCUMENTO,NU_DOCUMENTO,TX_PAIS,TX_ESTADO_CIVIL,TX_SEXO,"
			+ "FE_NACIMIENTO,TX_PROFESION,TX_OCUPACION,TX_ACTECO,MT_INGRESO,NU_TELEFONO,CALLE,"
			+ "TX_URBANIZACION,TX_CASA,TX_APARTAMENTO,TX_PARROQUIA,TX_MUNICIPIO,TX_CIUDAD,TX_ESTADO,"
			+ "TX_CORREO,MT_SUMA_ASEGURADA,NU_CUENTA,TP_CUENTA,CD_ASESOR,IN_VALIDAPRIMERNOMBRE,IN_VALIDAPRIMERAPELLIDO,"
			+ "NU_PLAZO_ESPERA,CD_REMESA,NU_TELEFONO_HAB,IN_DUPLICADO,IN_IVSS_VALIDACION,IN_VALIDA_CORREO,ST_GESTION_REMESA,NU_POLIZA,"
			+ "NU_EDAD,IN_VALIDA_TELEFONO_MOVIL,IN_VALIDA_FECHA_NACIMIENTO,IN_VALIDA_TELEFONO_LOCAL,IN_VALIDANUDOCUMENTO,nombre_crudo,correo_crudo,in_envio_solicitud_seguros, po_descuento_gestion,in_envio_cuadro_poliza "
			+ "FROM COREGESTIONREMESA where cd_proceso_tecnico=?1 and st_gestion_remesa=?2  and in_envio_solicitud_seguros=1  " , nativeQuery=true)

	public List<CoreGestionRemesa> fnBuscarPolizasPendientesParaEnvioDeSS(String pCdGestionRemesa, String pStGestionRemesa);
	
	@Query(value="SELECT CD_GESTION_REMESA,NM_APELLIDO1,NM_APELLIDO2,NM_NOMBRE1,"
			+ "NM_NOMBRE2,TP_DOCUMENTO,NU_DOCUMENTO,TX_PAIS,TX_ESTADO_CIVIL,TX_SEXO,"
			+ "FE_NACIMIENTO,TX_PROFESION,TX_OCUPACION,TX_ACTECO,MT_INGRESO,NU_TELEFONO,CALLE,"
			+ "TX_URBANIZACION,TX_CASA,TX_APARTAMENTO,TX_PARROQUIA,TX_MUNICIPIO,TX_CIUDAD,TX_ESTADO,"
			+ "TX_CORREO,MT_SUMA_ASEGURADA,NU_CUENTA,TP_CUENTA,CD_ASESOR,IN_VALIDAPRIMERNOMBRE,IN_VALIDAPRIMERAPELLIDO,"
			+ "NU_PLAZO_ESPERA,CD_REMESA,NU_TELEFONO_HAB,IN_DUPLICADO,IN_IVSS_VALIDACION,IN_VALIDA_CORREO,ST_GESTION_REMESA,NU_POLIZA,"
			+ "NU_EDAD,IN_VALIDA_TELEFONO_MOVIL,IN_VALIDA_FECHA_NACIMIENTO,IN_VALIDA_TELEFONO_LOCAL,IN_VALIDANUDOCUMENTO,nombre_crudo,correo_crudo,in_envio_solicitud_seguros, po_descuento_gestion,in_envio_cuadro_poliza "
			+ "FROM COREGESTIONREMESA where cd_proceso_campania=?1 and st_gestion_remesa=?2  and in_envio_solicitud_seguros=1  " , nativeQuery=true)

	public List<CoreGestionRemesa> fnBuscarPolizasPendientesParaEnvioDeSSCampania(String pCdGestionRemesa, String pStGestionRemesa);
	
	
	
	@Query(value="SELECT CD_GESTION_REMESA,NM_APELLIDO1,NM_APELLIDO2,NM_NOMBRE1,"
			+ "NM_NOMBRE2,TP_DOCUMENTO,NU_DOCUMENTO,TX_PAIS,TX_ESTADO_CIVIL,TX_SEXO,"
			+ "FE_NACIMIENTO,TX_PROFESION,TX_OCUPACION,TX_ACTECO,MT_INGRESO,NU_TELEFONO,CALLE,"
			+ "TX_URBANIZACION,TX_CASA,TX_APARTAMENTO,TX_PARROQUIA,TX_MUNICIPIO,TX_CIUDAD,TX_ESTADO,"
			+ "TX_CORREO,MT_SUMA_ASEGURADA,NU_CUENTA,TP_CUENTA,CD_ASESOR,IN_VALIDAPRIMERNOMBRE,IN_VALIDAPRIMERAPELLIDO,"
			+ "NU_PLAZO_ESPERA,CD_REMESA,NU_TELEFONO_HAB,IN_DUPLICADO,IN_IVSS_VALIDACION,IN_VALIDA_CORREO,ST_GESTION_REMESA,NU_POLIZA,in_envio_cuadro_poliza,"
			+ "NU_EDAD,IN_VALIDA_TELEFONO_MOVIL,IN_VALIDA_FECHA_NACIMIENTO,IN_VALIDA_TELEFONO_LOCAL,IN_VALIDANUDOCUMENTO,nombre_crudo,correo_crudo,in_envio_solicitud_seguros, po_descuento_gestion FROM COREGESTIONREMESA where cd_proceso_tecnico=?1 and in_valida_emision=2 and st_gestion_Remesa=?2 and IN_ENVIO_CUADRO_POLIZA=1 and nu_poliza is not null " , nativeQuery=true)

	public List<CoreGestionRemesa> fnBuscarCuadroPolizasPendientes(String pCdProceso, String pStGestionRemesa);
	


}
