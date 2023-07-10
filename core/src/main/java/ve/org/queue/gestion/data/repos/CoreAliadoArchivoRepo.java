package ve.org.queue.gestion.data.repos;


import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import ve.org.queue.gestion.data.pojos.CoreAliadoArchivo;

public interface CoreAliadoArchivoRepo extends JpaRepository<CoreAliadoArchivo, Long> {
	
	@Query(value="SELECT cd_aliado_archivo,NU_HOJAS,TX_EXTENSION,NU_COLUMNAS,CD_ALIADO FROM COREALIADOARCHIVO where CD_ALIADO=?1",nativeQuery=true)
	public List<CoreAliadoArchivo> fnBusquedaDt(String pCodigo);
}
