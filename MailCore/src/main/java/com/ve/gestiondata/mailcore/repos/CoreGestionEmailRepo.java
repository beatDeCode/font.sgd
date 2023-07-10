package com.ve.gestiondata.mailcore.repos;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

import com.ve.gestiondata.mailcore.pojos.CoreGestionEmailPojo;

public interface CoreGestionEmailRepo extends JpaRepository<CoreGestionEmailPojo, Long>{
	@Query(value="Select st_correo,tx_correo,tx_correo_enviado,cd_gestion_remesa,cd_gestion_email from COREGESTIONEMAIL",nativeQuery=true)
	public List<CoreGestionEmailPojo> fnBuscarCorreos();
}
