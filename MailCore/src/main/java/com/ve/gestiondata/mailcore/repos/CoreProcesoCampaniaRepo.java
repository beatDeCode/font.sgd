package com.ve.gestiondata.mailcore.repos;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import com.ve.gestiondata.mailcore.pojos.CoreProcesoCampaniaPojo;
import com.ve.gestiondata.mailcore.pojos.CoreProcesoTecnico;

public interface CoreProcesoCampaniaRepo extends JpaRepository<CoreProcesoCampaniaPojo, Long>{
	@Query(value="Select cd_proceso_campania,nu_consecutivo,fe_proceso, in_solicitud_seguros,in_emision,in_cuadro_poliza, st_proceso_campania "
			+ "from COREPROCESOCAMPANIA "
			+ " where cd_proceso_campania=?1 ",nativeQuery=true)
	public List<CoreProcesoTecnico> fnBuscarProcesoTecnicoEnProceso(String pCdProcesoTecnico);
	@Query(value="Select cd_proceso_campania,nu_consecutivo,fe_proceso, in_solicitud_seguros,in_emision,in_cuadro_poliza, st_proceso_campania "
			+ "from COREPROCESOCAMPANIA "
			+ " where cd_proceso_campania=?1 ",nativeQuery=true)
	public CoreProcesoTecnico fnBuscarProcesoTecnicoEnProcesoUni(String pCdProcesoTecnico);

}

