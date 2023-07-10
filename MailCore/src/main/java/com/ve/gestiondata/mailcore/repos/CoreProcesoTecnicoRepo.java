package com.ve.gestiondata.mailcore.repos;

import java.util.List;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

import com.ve.gestiondata.mailcore.pojos.CoreProcesoTecnico;


public interface CoreProcesoTecnicoRepo extends JpaRepository<CoreProcesoTecnico, Long> {

	@Query(value="Select max_edad,fe_proceso,cd_usuario,cd_remesa,in_solicitud_seguros,in_envio_cuadro_poliza,in_emision_masiva,min_edad,cd_proceso_tecnico,mt_suma_asegurada,po_descuento,in_solicitud_campania "
			+ "from COREPROCESOTECNICO "
			+ " where cd_proceso_tecnico=?1 ",nativeQuery=true)
	public List<CoreProcesoTecnico> fnBuscarProcesoTecnicoEnProceso(String pCdProcesoTecnico);
	@Query(value="Select max_edad,fe_proceso,cd_usuario,cd_remesa,in_solicitud_seguros,in_envio_cuadro_poliza,in_emision_masiva,min_edad,cd_proceso_tecnico,mt_suma_asegurada,po_descuento,in_solicitud_campania "
			+ "from COREPROCESOTECNICO "
			+ " where cd_proceso_tecnico=?1 ",nativeQuery=true)
	public CoreProcesoTecnico fnBuscarProcesoTecnicoEnProcesoUni(String pCdProcesoTecnico);
	
}
