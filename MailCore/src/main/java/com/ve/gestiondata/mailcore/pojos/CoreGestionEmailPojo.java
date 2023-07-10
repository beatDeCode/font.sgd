package com.ve.gestiondata.mailcore.pojos;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;
import lombok.Getter;
import lombok.Setter;

@Entity
@Table(name = "coregestionemail")
@Setter
@Getter
public class CoreGestionEmailPojo {
	@Id
	@Column(name="cd_gestion_email")
	private Long cdgestionemail;
	@Column(name="cd_gestion_remesa")
	private Long cdgestionremesa;
	@Column(name="tx_correo_enviado")
	private String txcorreoenviado;
	@Column(name="tx_correo")
	private String txcorreo;
	@Column(name="st_correo")
	private Long stcorreo;
}
