package ve.org.queue.gestion.data.repos;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

import ve.org.queue.gestion.data.pojos.CoreOrdenes;

public interface CoreOrdenesRepo extends JpaRepository<CoreOrdenes, Long> {
	
	@Query(value = "Select tx_nombre_archivo,tx_funcion_programa,tx_directorio_descarga,"
			+ "st_orden,parametro5,parametro4,parametro3,parametro2,parametro1,fe_orden_ini,"
			+ "fe_orden_fin,cd_usuario,cd_programa,cd_cola,cd_orden from COREORDENES "
			+ "where cd_cola=?1 "
			+ " and cd_orden in (select min(cd_orden) from COREORDENES where cd_cola=?1 and st_orden=1 )" 
			, nativeQuery = true)
	public List<CoreOrdenes> fnRetornaOrden(
			Long pCdCola
			) ;
	
	
}
