package com.ve.gestiondata.mailcore.servicios;


import java.util.ArrayList;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.PersistenceContext;
import javax.persistence.Query;
import org.springframework.stereotype.Service;

@Service
public class CustomSQL {
	@PersistenceContext
	private EntityManager entityManager;
	
	public List<String> fnRetornarValoresParaSelect(String pCampos, String pTabla,String pWhere) {
		List<Object[]> vRetornoQuery=null;
		List<String> vListaRetorno=new ArrayList<>();
		String vBusqueda="";
		try {
			vBusqueda="select "+pCampos+" FROM "+pTabla +" where "+pWhere;
			Query vQuery=entityManager.createNativeQuery(vBusqueda);
			vRetornoQuery=vQuery.getResultList();
			if(vRetornoQuery.size()>0) {
				for(Object[] v: vRetornoQuery) {
					 vListaRetorno.add(v[0]+"-"+v[1]);
				 }
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return vListaRetorno;
	}
	
	
}
