package ve.org.queue.gestion.data.pojos;
import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;

import lombok.Getter;
import lombok.Setter;

@Setter
@Getter
@Entity
@Table(name="coreordenes")
@SequenceGenerator(allocationSize = 1,sequenceName = "coreordenes_seq", name = "coreordenes_seq")
public class CoreOrdenes {
	
	@Id
	@GeneratedValue(strategy = GenerationType.SEQUENCE,generator ="coreordenes_seq" )
	@Column(name="cd_orden")
	private Long cdorden;
	@Column(name="cd_cola")
	private Long cdcola;
	@Column(name="cd_programa")
	private Long cdprograma;
	@Column(name="cd_usuario")
	private String  cdusuario;
	@Temporal(TemporalType.DATE)
	@Column(name="fe_orden_fin")
	private Date feordenfin;
	@Column(name="fe_orden_ini")
	private Date feordenini;
	@Column(name="parametro1")
	private String parametro1;
	@Column(name="parametro2")
	private String parametro2;
	@Column(name="parametro3")
	private String parametro3;
	@Column(name="parametro4")
	private String parametro4;
	@Column(name="parametro5")
	private String parametro5;
	@Column(name="st_orden")
	private Long storden;
	@Column(name="tx_directorio_descarga")
	private String txdirectoriodescarga;
	@Column(name="tx_funcion_programa")
	private String txfuncionprograma;
	@Column(name="tx_nombre_archivo")
	private String txnombrearchivo;
}
