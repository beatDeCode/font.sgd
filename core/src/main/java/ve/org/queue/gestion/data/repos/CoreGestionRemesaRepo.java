package ve.org.queue.gestion.data.repos;

import java.util.List;

import javax.transaction.Transactional;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;

import ve.org.queue.gestion.data.pojos.CoreGestionRemesa;



public interface CoreGestionRemesaRepo extends JpaRepository<CoreGestionRemesa, Long> {
	@Query(value="SELECT CD_GESTION_REMESA,NM_APELLIDO1,NM_APELLIDO2,NM_NOMBRE1,"
			+ "NM_NOMBRE2,TP_DOCUMENTO,to_char(to_number(NU_DOCUMENTO)) NU_DOCUMENTO,TX_PAIS,TX_ESTADO_CIVIL,TX_SEXO,"
			+ "FE_NACIMIENTO,TX_PROFESION,TX_OCUPACION,TX_ACTECO,MT_INGRESO,NU_TELEFONO,CALLE,"
			+ "TX_URBANIZACION,TX_CASA,TX_APARTAMENTO,TX_PARROQUIA,TX_MUNICIPIO,TX_CIUDAD,TX_ESTADO,"
			+ "TX_CORREO,MT_SUMA_ASEGURADA,NU_CUENTA,TP_CUENTA,CD_ASESOR,IN_VALIDAPRIMERNOMBRE,IN_VALIDAPRIMERAPELLIDO,"
			+ "NU_PLAZO_ESPERA,CD_REMESA,NU_TELEFONO_HAB,IN_DUPLICADO,IN_IVSS_VALIDACION,IN_VALIDA_CORREO,ST_GESTION_REMESA,"
			+ "NU_EDAD,IN_VALIDA_TELEFONO_MOVIL,IN_VALIDA_FECHA_NACIMIENTO,IN_VALIDA_TELEFONO_LOCAL,IN_VALIDANUDOCUMENTO,nombre_crudo,correo_crudo, "
			//+ "fe_nacimiento_adc2,sexo_adc_2,nu_documento_adc2,nm_apellido_adc2,nm_nombre_adc2,fe_nacimiento_adc1,nu_documento_adc1,sexo_adc_1,nm_apellido_adc1,nm_nombre_adc1,"
			+ "po_descuento_gestion,in_envio_solicitud_seguros "
			+ "FROM COREGESTIONREMESA where cd_remesa=?1 " , nativeQuery=true)

	public List<CoreGestionRemesa> fnRetornarDetalleRemesa(String pCdRemesa);
	
	@Query(value="SELECT CD_GESTION_REMESA,NM_APELLIDO1,NM_APELLIDO2,NM_NOMBRE1,"
			+ "NM_NOMBRE2,TP_DOCUMENTO,to_char(to_number(NU_DOCUMENTO)) NU_DOCUMENTO,TX_PAIS,TX_ESTADO_CIVIL,TX_SEXO,"
			+ "extract( day from to_Date(fe_nacimiento,'dd/mm/yyyy') )||'-'|| extract( month from to_Date(fe_nacimiento,'dd/mm/yyyy') )||'-'|| (extract(year from trunc(sysdate))-to_number(replace(nu_edad,'.0',''))) FE_NACIMIENTO,TX_PROFESION,TX_OCUPACION,TX_ACTECO,MT_INGRESO,NU_TELEFONO,CALLE,"
			+ "TX_URBANIZACION,TX_CASA,TX_APARTAMENTO,TX_PARROQUIA,TX_MUNICIPIO,TX_CIUDAD,TX_ESTADO,"
			+ "TX_CORREO,MT_SUMA_ASEGURADA,NU_CUENTA,TP_CUENTA,CD_ASESOR,IN_VALIDAPRIMERNOMBRE,IN_VALIDAPRIMERAPELLIDO,"
			+ "NU_PLAZO_ESPERA,CD_REMESA,NU_TELEFONO_HAB,IN_DUPLICADO,IN_IVSS_VALIDACION,IN_VALIDA_CORREO,ST_GESTION_REMESA,"
			+ "NU_EDAD,IN_VALIDA_TELEFONO_MOVIL,IN_VALIDA_FECHA_NACIMIENTO,IN_VALIDA_TELEFONO_LOCAL,IN_VALIDANUDOCUMENTO,nombre_crudo,correo_crudo, "
			//+ "fe_nacimiento_adc2,sexo_adc_2,nu_documento_adc2,nm_apellido_adc2,nm_nombre_adc2,fe_nacimiento_adc1,nu_documento_adc1,sexo_adc_1,nm_apellido_adc1,nm_nombre_adc1,"
			+ "po_descuento_gestion,in_envio_solicitud_seguros "
			+ "FROM COREGESTIONREMESA where cd_remesa=?1 and in_validaprimernombre=0  "
			+ "			and in_validaprimerapellido=0  "
			+ "			and in_validanudocumento=0 "
			+ "			and in_valida_correo=0 "
			+ "			and in_valida_telefono_movil=0  "
			+ "			and in_valida_telefono_local=0  "
			+ "			and in_valida_fecha_nacimiento=0 "
			+ "and case when abs(nvl(to_number(replace(nu_edad,'.0','')),0)-trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12))>"
			+ "                            (select cd_valor from gestiondata.coreparametros where cd_tabla='DIFERENCIA_EDAD_CALCULADA') then 1 else 0 end = 1 " , nativeQuery=true)

	public List<CoreGestionRemesa> fnRetornarRemesaConErroresEnFechaNacimiento(String pCdRemesa);
	
	@Query(value="SELECT CD_GESTION_REMESA,NM_APELLIDO1,NM_APELLIDO2,NM_NOMBRE1,"
			+ "NM_NOMBRE2,TP_DOCUMENTO,to_char(to_number(NU_DOCUMENTO)) NU_DOCUMENTO,TX_PAIS,TX_ESTADO_CIVIL,TX_SEXO,"
			+ "extract( day from to_Date(fe_nacimiento,'dd/mm/yyyy') )||'-'|| extract( month from to_Date(fe_nacimiento,'dd/mm/yyyy') )||'-'|| (extract(year from trunc(sysdate))-to_number(replace(nu_edad,'.0',''))) FE_NACIMIENTO,TX_PROFESION,TX_OCUPACION,TX_ACTECO,MT_INGRESO,NU_TELEFONO,CALLE,"
			+ "TX_URBANIZACION,TX_CASA,TX_APARTAMENTO,TX_PARROQUIA,TX_MUNICIPIO,TX_CIUDAD,TX_ESTADO,"
			+ "TX_CORREO,MT_SUMA_ASEGURADA,NU_CUENTA,TP_CUENTA,CD_ASESOR,IN_VALIDAPRIMERNOMBRE,IN_VALIDAPRIMERAPELLIDO,"
			+ "NU_PLAZO_ESPERA,CD_REMESA,NU_TELEFONO_HAB,IN_DUPLICADO,IN_IVSS_VALIDACION,IN_VALIDA_CORREO,ST_GESTION_REMESA,"
			+ "NU_EDAD,IN_VALIDA_TELEFONO_MOVIL,IN_VALIDA_FECHA_NACIMIENTO,IN_VALIDA_TELEFONO_LOCAL,IN_VALIDANUDOCUMENTO,nombre_crudo,correo_crudo, "
			//+ "fe_nacimiento_adc2,sexo_adc_2,nu_documento_adc2,nm_apellido_adc2,nm_nombre_adc2,fe_nacimiento_adc1,nu_documento_adc1,sexo_adc_1,nm_apellido_adc1,nm_nombre_adc1,"
			+ "po_descuento_gestion,in_envio_solicitud_seguros "
			+ "FROM COREGESTIONREMESA where cd_remesa=?1 and in_validaprimernombre=0  "
			+ "			and in_validaprimerapellido=1  "
			+ "			and in_validanudocumento=1 "
			+ "			and in_valida_correo=1 "
			+ "			and in_valida_telefono_movil=1  "
			+ "			and in_valida_telefono_local=1  "
			+ "			and in_valida_fecha_nacimiento=1 " , nativeQuery=true)

	public List<CoreGestionRemesa> fnRetornarRemesaParaValidarCorreo(String pCdRemesa);
	@Transactional
	@Modifying
	@Query(value="update coregestionremesa  "
			+ "set in_validaprimernombre=1, "
			+ "in_validaprimerapellido=1, "
			+ "in_validanudocumento=1, "
			+ "in_valida_correo=1, "
			+ "in_valida_telefono_movil=1, "
			+ "in_valida_telefono_local=1, "
			+ "in_valida_fecha_nacimiento=1, "
			+ "st_gestion_remesa=3 "
			+ "where cd_gestion_remesa in ( "
			+ "select cd_gestion_remesa "
			+ "from gestiondata.coregestionremesa reme "
			+ "where  tx_correo is not null "
			+ "and nm_nombre1 is not null "
			+ "and nm_apellido1 is not null "
			+ "and nu_telefono is not null "
			+ "and cd_remesa=?1 "
			+ "and nu_documento is not null "
			+ "and length(nu_telefono)=10 "
			+ " and case when abs(nvl(to_number(replace(nu_edad,'.0','')),0)-trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12))<= "
			+ "                            (select cd_valor from gestiondata.coreparametros where cd_tabla='DIFERENCIA_EDAD_CALCULADA') then 1 else 0 end = 1"
			+ "and case when length(nu_telefono)=10  "
			+ "    then  "
			+ "        case when substr(nu_telefono,1,3) in ('424','414','412','416','426') then 1 else 0 end "
			+ "    else "
			+ "        0 "
			+ "    end = 1 "
			+ " and in_ivss_validacion=1)" ,nativeQuery=true)
	public void fnActualizarRemesaIvss(String pCdRemesa);
	
	@Transactional
	@Modifying
	@Query(value="update coregestionremesa  "
			+ "set in_validaprimernombre=1, "
			+ "in_validaprimerapellido=1, "
			+ "in_validanudocumento=1, "
			+ "in_valida_correo=1, "
			+ "in_valida_telefono_movil=1, "
			+ "in_valida_telefono_local=1, "
			+ "in_valida_fecha_nacimiento=1, "
			+ "st_gestion_remesa=3,"
			+ "nu_documento=to_char(to_number(nu_documento)) "
			+ "where cd_gestion_remesa in ( "
			+ "select cd_gestion_remesa "
			+ "from gestiondata.coregestionremesa reme "
			+ "where  tx_correo is not null "
			+ "and nm_nombre1 is not null "
			+ "and nm_apellido1 is not null "
			+ "and nu_telefono is not null "
			+ "and cd_remesa=?1 "
			+ "and nu_documento is not null "
			+ "and length(nu_telefono)=10 "
			+ " and case when abs(nvl(to_number(replace(nu_edad,'.0','')),0)-trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12))<= "
			+ "                            (select cd_valor from gestiondata.coreparametros where cd_tabla='DIFERENCIA_EDAD_CALCULADA') then 1 else 0 end = 1"
			+ "and case when length(nu_telefono)=10  "
			+ "    then  "
			+ "        case when substr(nu_telefono,1,3) in ('424','414','412','416','426') then 1 else 0 end "
			+ "    else "
			+ "        0 "
			+ "    end = 1 "
			+ ")" ,nativeQuery=true)
	public void fnActualizarRemesa(String pCdRemesa);
	
	@Transactional
	@Modifying
	@Query(value="update "
			+ "gestiondata.coregestionremesa reme "
				+ "set in_validaprimernombre=0, "
				+ "in_validaprimerapellido=0, "
				+ "in_validanudocumento=0, "
				+ "in_valida_correo=0, "
				+ "in_valida_telefono_movil=0, "
				+ "in_valida_telefono_local=0, "
				+ "in_valida_fecha_nacimiento=0,"
			+ "st_gestion_remesa=3 "
			+ "where cd_remesa=?1 "
			+ "and st_gestion_remesa is null ", nativeQuery=true)
	public void  fnActualizarRemesaNoOptima(String pCdRemesa);
	@Transactional
	@Modifying
	@Query(value="update coregestionremesa core "
			+ "set core.IN_DUPLICADO=5 "
			+ "where nu_documento in ( "
			+ "    select  "
			+ "       nu_documento "
			+ "    nu_documento from ( "
			+ "        select count(1) cuenta,nu_documento from coregestionremesa "
			+ "        where cd_remesa=?1 "
			+ "        group by nu_documento "
			+ "    )a1 "
			+ "    where cuenta>1 "
			+ " and cd_remesa=?1 "
			+ ")", nativeQuery=true)
	public void  fnMarcarDuplicadosEnElArchivo(String pCdRemesa);
	
	
	@Transactional
	@Modifying
	@Query(value="update coregestionremesa core "
			+ "set core.IN_DUPLICADO=null "
			+ "where cd_remesa=?1 "
			+ "and cd_gestion_remesa in ( "
				+ "    select cd_gestion_remesa "
				+ "	   from "	
				+ " (select max(cd_gestion_remesa) cd_gestion_remesa, nu_documento from coregestionremesa "
				+ "    where IN_DUPLICADO=5 "
				+ "    group by nu_documento"
			+ "		) "
			+ ") "
			+ "and cd_remesa=?1 ", nativeQuery=true)
	public void  fnActualizarPrimerRegistroMarcadoDuplicado(String pCdRemesa);

	@Transactional
	@Modifying
	@Query(value=
			  " update coregestionremesa"
			+ "	set in_duplicado=1 "
			+ "	where cd_gestion_remesa "
			+ "	in("
				+ "	select cd_gestion_remesa from ("
				+ "	select nu_documento,"
				+ "	cd_gestion_remesa,"
				+ "	(select count(1) from coregestionremesa reme2 where reme2.nu_documento=reme1.nu_documento and reme2.cd_remesa!=reme1.cd_remesa) cuenta"
				+ "	from coregestionremesa reme1 "
				+ "	where cd_remesa=?1 and st_gestion_remesa=3"
			+ "	)where cuenta>0 "
			+ "	)", nativeQuery=true)
	public int fnActualizarRemesaConDuplicados(String pCdRemesa);
	@Transactional
	@Modifying
	@Query(value=
			  "update gestiondata.coregestionremesa reme "
			  + "set reme.PO_DESCUENTO_GESTION= "
			  + "	(select po_descuento from corereporteedad  "
			  + "    	where  "
			  + "    	cd_aliado= ?2"
			  + "		and trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12) between min_edad and max_Edad "
			  + "	) "
			  + " where st_gestion_remesa=3  "
			  + "and cd_remesa=?1", nativeQuery=true)
	public int fnActualizarPorcentajeDescuento(String pCdRemesa, String pCdAliado);

	@Transactional
	@Modifying
	@Query(value=
			  "update coregestionremesa "
			  + "set in_duplicado=1,nu_documento=to_char(to_number(nu_documento)) "
			  + "where cd_gestion_remesa in ( "
			  + " select cd_gestion_remesa from (  "
			  + "			       select    "
			  + "			            (select count(1) from sir.polizacertificado where cd_persona_asegurada=(select cd_persona from sir.persona pers where pers.nu_documento=core.nu_documento and rownum<=1) and  st_certificado=1)cuenta_titular,  "
			  + "			            cd_gestion_remesa, "
			  + "			            (select  "
			  + "			            case when count(1)>0 then 1 else 0 end cuenta  "
			  + "			            from SIR.POLIZACERTENDOSOBIENGRUPOASEG grupo, sir.polizacertificado pcer  "
			  + "			            where pcer.cd_area=grupo.cd_area "
			  + "						and pcer.cd_entidad=grupo.cd_entidad "
			  + "						and pcer.nu_poliza=grupo.nu_poliza "
			  + "						and pcer.nu_certificado=grupo.nu_certificado "
			  + "						and pcer.st_certificado=1  "
			  + "			            and cd_persona=(select cd_persona from persona where nu_documento=core.nu_documento and rownum<=1)  "
			  + "			            and (select st_certificado from sir.polizacertificado where nu_poliza=grupo.nu_poliza and rownum<=1 )=1 ) cuenta_asegurado  "
			  + "			       from coregestionremesa core  "
			  + "			       where cd_remesa=?1 "
			  + "			  ) "
			  + "			  where cuenta_titular>0 or cuenta_asegurado>0"
			  + ")", nativeQuery=true)
	public int fnActualizarDuplicadosSIR(String pCdRemesa);
	
	@Query(value="SELECT CD_GESTION_REMESA,NM_APELLIDO1,NM_APELLIDO2,NM_NOMBRE1,"
			+ "NM_NOMBRE2,TP_DOCUMENTO,NU_DOCUMENTO,TX_PAIS,TX_ESTADO_CIVIL,TX_SEXO,"
			+ "FE_NACIMIENTO,TX_PROFESION,TX_OCUPACION,TX_ACTECO,MT_INGRESO,NU_TELEFONO,CALLE,"
			+ "TX_URBANIZACION,TX_CASA,TX_APARTAMENTO,TX_PARROQUIA,TX_MUNICIPIO,TX_CIUDAD,TX_ESTADO,"
			+ "TX_CORREO,MT_SUMA_ASEGURADA,NU_CUENTA,TP_CUENTA,CD_ASESOR,IN_VALIDAPRIMERNOMBRE,IN_VALIDAPRIMERAPELLIDO,"
			+ "NU_PLAZO_ESPERA,CD_REMESA,NU_TELEFONO_HAB,IN_DUPLICADO,IN_IVSS_VALIDACION,IN_VALIDA_CORREO,ST_GESTION_REMESA,"
			+ "NU_EDAD,IN_VALIDA_TELEFONO_MOVIL,IN_VALIDA_FECHA_NACIMIENTO,IN_VALIDA_TELEFONO_LOCAL,IN_VALIDANUDOCUMENTO,nombre_crudo,correo_crudo, "
			//+ "fe_nacimiento_adc2,sexo_adc_2,nu_documento_adc2,nm_apellido_adc2,nm_nombre_adc2,fe_nacimiento_adc1,nu_documento_adc1,sexo_adc_1,nm_apellido_adc1,nm_nombre_adc1,"
			+ "po_descuento_gestion,in_envio_solicitud_seguros "
			+ "FROM COREGESTIONREMESA where cd_remesa=?1 " , nativeQuery=true)

	public List<CoreGestionRemesa> fnRetornar(String pCdRemesa);
	

}
