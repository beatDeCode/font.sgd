package ve.org.queue.gestion.data.repos;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import ve.org.queue.gestion.data.pojos.CoreEstructuraRemesa;

public interface CoreEstructuraRemesaRepo extends JpaRepository<CoreEstructuraRemesa, Long> {
	
	@Query(value=" SELECT CD_ESTRUCTURA_REMESA,TX_NOMBRE_CAMPO,TX_NOMBRE_POJO,NU_COLUMNA_INICIO,NU_COLUMNA_FIN,"
			+ "CD_VALIDACION,TP_ESCRITURA,TP_ARCHIVO,ST_ARCHIVO,TP_REGISTRO,NU_LINEA,ST_ESTRUCTURA,TX_VALORES_REEMPLAZO,CD_ALIANZA,CD_VALIDACION2 "
			+ "from COREESTRUCTURAREMESA where CD_ALIANZA=?1 and tp_archivo=?2  order by CD_ESTRUCTURA_REMESA" , nativeQuery=true)

	public List <CoreEstructuraRemesa>fnEstructururaInserta(String pCdAlianza,String pTpArchivo);
	
	
	@Query(value=" SELECT CD_ESTRUCTURA_REMESA,TX_NOMBRE_CAMPO,TX_NOMBRE_POJO,NU_COLUMNA_INICIO,NU_COLUMNA_FIN,"
			+ "CD_VALIDACION,TP_ESCRITURA,TP_ARCHIVO,ST_ARCHIVO,TP_REGISTRO,NU_LINEA,ST_ESTRUCTURA,TX_VALORES_REEMPLAZO,CD_ALIANZA,CD_VALIDACION2 "
			+ "from COREESTRUCTURAREMESA where CD_ALIANZA=?1 and tp_archivo=2 order by CD_ESTRUCTURA_REMESA" , nativeQuery=true)

	public List <CoreEstructuraRemesa>fnEstructururaExtrae(String pCdAlianza);
	

	
}
