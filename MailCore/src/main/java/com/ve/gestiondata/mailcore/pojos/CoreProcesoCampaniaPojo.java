package com.ve.gestiondata.mailcore.pojos;

import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;

import lombok.Getter;
import lombok.Setter;

@Table( name="coreprocesocampania")
@Entity
@Setter
@Getter
public class CoreProcesoCampaniaPojo {
	@Id
	@Column(name="cd_proceso_campania")
	private int cdprocesocampania;
	@Column(name="fe_proceso")
	private Date feproceso;
	@Column(name="nu_consecutivo")
	private int nuconsecutivo;
	@Column(name="in_solicitud_seguros")
	private int insolicitudseguros;
	@Column(name="in_emision")
	private int inemision;
	@Column(name="in_cuadro_poliza")
	private int incuadropoliza;
	@Column(name="st_proceso_campania")
	private int stprocesocampania;
}
