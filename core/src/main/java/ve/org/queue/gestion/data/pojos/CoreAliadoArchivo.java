package ve.org.queue.gestion.data.pojos;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;
import lombok.Getter;
import lombok.Setter;

@Entity
@Table(name = "COREALIADOARCHIVO")
@Getter
@Setter

public class CoreAliadoArchivo {
	@Id
	@Column(name="cd_aliado_archivo")
	private Long cdarchivoaliado;
	@Column(name="cd_aliado")
	private Long cdaliado;
	@Column(name="nu_columnas")
	private Long nucolumnas;
	@Column(name="tx_extension")
	private String txextension;
	@Column(name="nu_hojas")
	private Long nuhojas;
	
	
}
