package ve.org.queue.gestion.data.services;

import javax.persistence.EntityManager;
import javax.persistence.ParameterMode;
import javax.persistence.PersistenceContext;
import javax.persistence.StoredProcedureQuery;
import org.springframework.stereotype.Service;
import ve.org.queue.gestion.data.pojos.CoreOrdenes;

@Service
public class CoreEmisionPolizas {
	
	@PersistenceContext
	private EntityManager entityManager;
	
	public void fnGenerarEmision(CoreOrdenes pOrden) {
		try {
			StoredProcedureQuery vEjecucionEmisionMasiva = entityManager
				    .createStoredProcedureQuery("GESTIONDATA.pck_gestion_data_emision.pd_ejecucion_proceso_emision")
				    .registerStoredProcedureParameter(1,Long.class,ParameterMode.IN)
				    .setParameter(1, Long.valueOf(pOrden.getParametro1()));
			vEjecucionEmisionMasiva.execute();
			
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

}