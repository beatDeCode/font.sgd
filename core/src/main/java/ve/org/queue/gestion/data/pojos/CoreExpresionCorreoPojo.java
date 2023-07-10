package ve.org.queue.gestion.data.pojos;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;

import lombok.Getter;
import lombok.Setter;

@Setter
@Getter
@Entity
@Table(name = "coreexpresionescorreo")
public class CoreExpresionCorreoPojo {
	
	@Id
	@Column(name="cd_expresion")
	private Long cdexpresion;
	@Column(name="tx_expresion")
	private String txexpresion;
	@Column(name="tx_modificacion")
	private String txmodificacion;
}
