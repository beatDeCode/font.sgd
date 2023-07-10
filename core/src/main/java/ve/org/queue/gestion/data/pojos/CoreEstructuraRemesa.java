package ve.org.queue.gestion.data.pojos;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
@Entity
@Table(name = "COREESTRUCTURAREMESA")
public class CoreEstructuraRemesa {
	@Id
	@Column(name="cd_estructura_remesa")
	private Long cdestructuraremesa;
	@Column(name="tx_nombre_campo")
	private String txnombrecampo;
	@Column(name="tx_nombre_pojo")
	private String txnombrepojo;
	@Column(name="nu_columna_inicio")
	private Long nucolumnainicio;
	@Column(name="nu_columna_fin")
	private Long nucolumnafin;
	@Column(name="cd_validacion")
	private Long cdvalidacion;
	@Column(name="tp_escritura")
	private Long tpescritura;
	@Column(name="tp_archivo")
	private Long tparchivo;
	@Column(name="st_archivo")
	private Long starchivo;
	@Column(name="tp_registro")
	private Long tpregistro;
	@Column(name="nu_linea")
	private Long nulinea;
	@Column(name="st_estructura")
	private Long stestructura;
	@Column(name="tx_valores_reemplazo")
	private String txvaloresreemplazo;
	@Column(name="cd_alianza")
	private Long cdalianza;
	@Column(name="cd_validacion2")
	private Long cdvalidacion2;
}
