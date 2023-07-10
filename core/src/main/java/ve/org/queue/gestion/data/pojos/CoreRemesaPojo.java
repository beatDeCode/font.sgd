package ve.org.queue.gestion.data.pojos;

import java.util.Date;

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

@Setter
@Getter
@Entity
@Table(name = "coreremesa")
@SequenceGenerator(allocationSize = 1,sequenceName = "COREREMESA_SEQ", name = "COREREMESA_SEQ")

public class CoreRemesaPojo {
	@Id
	@GeneratedValue(strategy = GenerationType.SEQUENCE,generator ="COREREMESA_SEQ" )
	@Column(name="cd_remesa")
	private Long cdremesa;
	@Column(name="cd_aliado")
	private Long cdaliado;
	@Column(name="cd_producto")
	private Long cdproducto;
	@Column(name="fe_remesa")
	private Date feremesa;
	@Column(name="st_remesa")
	private Long stremesa;
	@Column(name="cd_usuario")
	private String cdusuario;
	@Column(name="nm_remesa")
	private String nmremesa;
	@Column(name="nu_registros_estimados")
	private Long nuregistrosestimados;
	@Column(name="tx_log_remesa")
	private String txlogremesa;
	@Column(name="nu_registros_cargados")
	private Long nuregistroscargados;
	@Column(name="st_validacion_ivss")
	private Long stvalidacionivss;
	@Column(name="st_validacion_nombre")
	private Long stvalidacionnombre;
	@Column(name="nu_consecutivo_remesa")
	private Long nuconsecutivoremesa;
	@Transient
	private String txproducto;
	@Transient
	private String txaliado;
	@Transient
	private String txbanco;
	@Transient
	private String txcampania;
	
 	
}
