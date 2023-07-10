package ve.org.queue.gestion.data.pojos;

import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;

import lombok.Getter;
import lombok.Setter;

@Entity
@Table(name="coreprocesotecnico")
@Getter
@Setter
@SequenceGenerator(allocationSize = 1,sequenceName = "coreprocesotecnico_seq", name = "coreprocesotecnico_seq")
public class CoreProcesoTecnico {
	@Id
	@GeneratedValue(strategy = GenerationType.SEQUENCE,generator ="coreprocesotecnico_seq" )
	@Column(name="cd_proceso_tecnico")
	private Long cdprocesotecnico;
	@Column(name="min_edad")
	private Long minedad;
	@Column(name="in_emision_masiva")
	private Long inemisionmasiva;
	@Column(name="in_envio_cuadro_poliza")
	private Long inenviocuadropoliza;
	@Column(name="in_solicitud_seguros")
	private Long insolicitudseguros;
	@Column(name="cd_remesa")
	private Long cdremesa;
	@Column(name="cd_usuario")
	private String cdusuario;
	@Column(name="fe_proceso")
	private Date feproceso;
	@Column(name="max_edad")
	private Long maxedad;
	@Column(name="mt_suma_asegurada")
	private Long mtsumaasegurada;
	@Column(name="po_descuento")
	private Long podescuento;
	@Column(name="in_solicitud_campania")
	private Long insolicitudcampania;
	
	
	
}
