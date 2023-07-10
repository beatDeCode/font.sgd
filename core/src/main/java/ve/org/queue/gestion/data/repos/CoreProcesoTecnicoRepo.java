package ve.org.queue.gestion.data.repos;

import java.util.List;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

import ve.org.queue.gestion.data.pojos.CoreProcesoTecnico;


public interface CoreProcesoTecnicoRepo extends JpaRepository<CoreProcesoTecnico, Long> {
	@Query(value="Select tx_correo_solicitud_seguros,max_edad,fe_proceso,cd_usuario,cd_remesa,in_solicitud_seguros,in_envio_cuadro_poliza,in_emision_masiva,min_edad,cd_proceso_tecnico,mt_suma_asegurada,po_descuento,in_solicitud_campania "
			+ " from COREPROCESOTECNICO"
			+ " where cd_remesa=?1 and min_edad=?2 and max_edad=?3",nativeQuery=true)
	public List<CoreProcesoTecnico> fnBuscarExistenciaDeProcesosTecnicosPorRemesa(String pCdRemesa,Long pMinEdad, Long pMaxEdad);
	@Query(value="Select tx_correo_solicitud_seguros,max_edad,fe_proceso,cd_usuario,cd_remesa,in_solicitud_seguros,in_envio_cuadro_poliza,in_emision_masiva,min_edad,cd_proceso_tecnico,mt_suma_asegurada,po_descuento,in_solicitud_campania "
			+ "from COREPROCESOTECNICO "
			+ " where cd_proceso_tecnico=?1 and in_solicitud_seguros=0 ",nativeQuery=true)
	public List<CoreProcesoTecnico> fnBuscarProcesoTecnicoEnProceso(String pCdProcesoTecnico);
	@Query(value="Select tx_correo_solicitud_seguros,max_edad,fe_proceso,cd_usuario,cd_remesa,in_solicitud_seguros,in_envio_cuadro_poliza,in_emision_masiva,min_edad,cd_proceso_tecnico,mt_suma_asegurada,po_descuento,in_solicitud_campania "
			+ "from COREPROCESOTECNICO "
			+ " where cd_proceso_tecnico=?1 and in_emision_masiva=0 ",nativeQuery=true)
	public List<CoreProcesoTecnico> fnBuscarProcesoTecnicoEmision(String pCdProcesoTecnico);
}
