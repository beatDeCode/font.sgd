package ve.org.queue.gestion.data.pojos;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;

import lombok.Getter;
import lombok.Setter;

@Setter
@Getter
@Entity
@Table(name="coregestionremesa")
@SequenceGenerator(allocationSize = 1,sequenceName = "coregestionremesa_seq", name = "coregestionremesa_seq")
public class CoreGestionRemesa {
	@Id
	@GeneratedValue(strategy = GenerationType.SEQUENCE,generator ="coregestionremesa_seq" )
	@Column(name="cd_gestion_remesa")
	private Long cdgestionremesa;
	@Column(name="nm_apellido1")
	private String nmapellido1;
	@Column(name="nm_apellido2")
	private String nmapellido2;
	@Column(name="nm_nombre1")
	private String nmnombre1;
	@Column(name="nm_nombre2")
	private String nmnombre2;
	@Column(name="tp_documento")
	private String tpdocumento;
	@Column(name="nu_documento")
	private String nudocumento;
	@Column(name="tx_pais")
	private String txpais;
	@Column(name="tx_estado_civil")
	private String txestadocivil;
	@Column(name="tx_sexo")
	private String txsexo;
	@Column(name="fe_nacimiento")
	private String fenacimiento;
	@Column(name="tx_profesion")
	private String txprofesion;
	@Column(name="tx_ocupacion")
	private String txocupacion;
	@Column(name="tx_acteco")
	private String txacteco;
	@Column(name="mt_ingreso")
	private String mtingreso;
	@Column(name="nu_telefono")
	private String nutelefono;
	@Column(name="calle")
	private String calle;
	@Column(name="tx_urbanizacion")
	private String txurbanizacion;
	@Column(name="tx_casa")
	private String txcasa;
	@Column(name="tx_apartamento")
	private String txapartamento;
	@Column(name="tx_parroquia")
	private String txparroquia;
	@Column(name="tx_municipio")
	private String txmunicipio;
	@Column(name="tx_ciudad")
	private String txciudad;
	@Column(name="tx_estado")
	private String txestado;
	@Column(name="tx_correo")
	private String txcorreo;
	@Column(name="mt_suma_asegurada")
	private String mtsumaasegurada;
	@Column(name="nu_cuenta")
	private String nucuenta;
	@Column(name="tp_cuenta")
	private String tpcuenta;
	@Column(name="cd_asesor")
	private Long cdasesor;
	@Column(name="nu_plazo_espera")
	private Long nuplazoespera;
	@Column(name="cd_remesa")
	private Long cdremesa;
	@Column(name="nu_telefono_hab")
	private String nutelefonohab;
	@Column(name="in_duplicado")
	private Long induplicado;
	@Column(name="in_ivss_validacion")
	private Long inivssvalidacion;
	@Column(name="in_valida_correo")
	private Long invalidacorreo;
	@Column(name="st_gestion_remesa")
	private Long stgestionremesa;
	@Column(name="nu_edad")
	private String nuedad;
	@Column(name="in_valida_telefono_movil")
	private Long invalidatelefonomovil;
	@Column(name="in_valida_fecha_nacimiento")
	private Long invalidafechanacimiento;
	@Column(name="in_valida_telefono_local")
	private Long invalidatelefonolocal;
	@Column(name="in_validanudocumento")
	private Long invalidanudocumento;
	@Column(name="in_validaprimernombre")
	private Long invalidaprimernombre;
	@Column(name="in_validaprimerapellido")
	private Long invalidaprimerapellido;
	@Column(name="nombre_crudo")
	private String nombrecrudo;
	@Column(name="correo_crudo")
	private String correocrudo;
	/*
	@Column(name="nm_nombre_adc1")
	private String nmnombreadc1;
	@Column(name="nm_apellido_adc1")
	private String nmapellidoadc1;
	@Column(name="sexo_adc_1")
	private String sexoadc1;
	@Column(name="nu_documento_adc1")
	private String nudocumentoadc1;
	@Column(name="fe_nacimiento_adc1")
	private String fenacimientoadc1;
	@Column(name="nm_nombre_adc2")
	private String nmnombreadc2;
	@Column(name="nm_apellido_adc2")
	private String nmapellidoadc2;
	@Column(name="nu_documento_adc2")
	private String nudocumentoadc2;
	@Column(name="sexo_adc_2")
	private String sexoadc2;
	@Column(name="fe_nacimiento_adc2")
	private String fenacimientoadc2;*/
	@Column(name="po_descuento_gestion")
	private String podescuentogestion;
	@Column(name="in_envio_solicitud_seguros")
	private Long inenviosolicitudseguros;

}
