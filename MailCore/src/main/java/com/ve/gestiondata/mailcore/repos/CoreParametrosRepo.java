package com.ve.gestiondata.mailcore.repos;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

import com.ve.gestiondata.mailcore.pojos.CoreParametrosPojo;


public interface CoreParametrosRepo extends JpaRepository<CoreParametrosPojo, Long>{
	
	@Query( value="SELECT ST_PARAMETRO,CD_VALOR,CD_TABLA,CD_PARAMETRO FROM COREPARAMETROS where cd_tabla=?1",nativeQuery=true)
	public CoreParametrosPojo fnBusquedaValoresDataTables(String pCdTabla);
	
	@Query( value="SELECT ST_PARAMETRO,CD_VALOR,CD_TABLA,CD_PARAMETRO FROM COREPARAMETROS where cd_parametro=?1",nativeQuery=true)
	public CoreParametrosPojo fnBusquedaValorPorCodigo(String pCdParamtro);
	
	@Query(value="SELECT ST_PARAMETRO,CD_VALOR,CD_TABLA,CD_PARAMETRO "
			+ " FROM COREPARAMETROS where cd_tabla=?1 and cd_valor=?2",
			nativeQuery=true)
	public List<CoreParametrosPojo> fnValidaConstraint(String pCdTabla,String pCdValor);

}
