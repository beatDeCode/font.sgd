package ve.org.queue.gestion.data.repos;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

import ve.org.queue.gestion.data.pojos.CoreExpresionCorreoPojo;

public interface CoreExpresionCorreoRepo extends JpaRepository<CoreExpresionCorreoPojo, Long> {
	@Query(value="SELECT CD_EXPRESION,TX_EXPRESION,TX_MODIFICACION FROM COREEXPRESIONESCORREO where upper(tx_expresion)=?1" , nativeQuery=true)
	public List<CoreExpresionCorreoPojo> fnBuscarExpresion(String pExpresion);
}
