package com.ve.gestiondata.mailcore.pojos;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;
import javax.persistence.Transient;

import lombok.Getter;
import lombok.Setter;

@Table( name="coreparametros")
@Entity
@Setter
@Getter
@SequenceGenerator(allocationSize = 1,sequenceName = "COREPARAMETROS_SEQ", name = "COREPARAMETROS_SEQ")
public class CoreParametrosPojo {
	
	@Id
	@GeneratedValue(strategy = GenerationType.SEQUENCE,generator ="COREPARAMETROS_SEQ")
	@Column(name="cd_parametro")
	private Long cdparametro;
	@Column(name="cd_tabla")
	private String cdtabla;
	@Column(name="cd_valor")
	private String cdvalor;
	@Column(name="st_parametro")
	private Long stparametro;
	@Transient
	private String txstatus;

}
