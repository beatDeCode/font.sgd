package ve.org.queue.gestion.data.repos;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

import ve.org.queue.gestion.data.pojos.CoreRemesaPojo;


public interface CoreRemesaRepo extends JpaRepository<CoreRemesaPojo, Long> {
	
	@Query(value="SELECT CD_REMESA,CD_ALIADO,CD_PRODUCTO,FE_REMESA,ST_REMESA,CD_USUARIO,NM_REMESA,NU_REGISTROS_ESTIMADOS,st_validacion_ivss,st_validacion_nombre,(select count(1) from coregestionremesa where cd_remesa=reme.cd_remesa) NU_REGISTROS_CARGADOS,tx_log_remesa,nu_consecutivo_remesa from COREREMESA reme where cd_remesa=?1" , nativeQuery=true)
	public List<CoreRemesaPojo> fnBusquedaDt(String pCodigo);
	
	@Query(value="SELECT CD_REMESA,CD_ALIADO,CD_PRODUCTO,FE_REMESA,ST_REMESA,CD_USUARIO,NM_REMESA,NU_REGISTROS_ESTIMADOS, st_validacion_ivss,st_validacion_nombre,(select count(1) from coregestionremesa where cd_remesa=reme.cd_remesa) NU_REGISTROS_CARGADOS,tx_log_remesa,nu_consecutivo_remesa from COREREMESA reme where CD_REMESA=?1 ", nativeQuery=true)
	public CoreRemesaPojo fnPorCodigo(String pCodigo);
}

