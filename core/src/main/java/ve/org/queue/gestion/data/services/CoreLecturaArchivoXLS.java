package ve.org.queue.gestion.data.services;

import java.io.File;
import java.io.FileInputStream;
import java.lang.reflect.Method;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;

import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.ss.usermodel.CellType;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;

import ve.org.queue.gestion.data.pojos.CoreAliadoArchivo;
import ve.org.queue.gestion.data.pojos.CoreEstructuraRemesa;
import ve.org.queue.gestion.data.pojos.CoreGestionRemesa;
import ve.org.queue.gestion.data.pojos.CoreOrdenes;
import ve.org.queue.gestion.data.pojos.CoreRemesaPojo;
import ve.org.queue.gestion.data.repos.CoreAliadoArchivoRepo;
import ve.org.queue.gestion.data.repos.CoreEstructuraRemesaRepo;
import ve.org.queue.gestion.data.repos.CoreGestionRemesaRepo;
import ve.org.queue.gestion.data.repos.CoreRemesaRepo;

@Service
public class CoreLecturaArchivoXLS {
	@Autowired
	private CoreRemesaRepo coreRemesaRepo;
	
	@Autowired
	private CoreAliadoArchivoRepo coreAliadoArchivoRepo;
	
	@Autowired
	private CoreEstructuraRemesaRepo coreEstructuraRemesaRepo;
	
	@Autowired
	private UtilesServices utilesServices;
	
	@Autowired
	private CoreGestionRemesaRepo coreGestionRemesaRepo;
	
	@Value("${core.validacion.nombres}")
	private String aValidacionNombres;
	
	@Value("${core.validacion.nombres.arr}")
	private String aValidacionNombresArr;
	
	public List<String> fnLectura(
			String pCdALiado,
			String pCdProducto,
			String pCdRemesa,
			String vDirectorioArchivo,
			String vNombreArchivo){
		List<CoreRemesaPojo> vCoreRemesa=coreRemesaRepo.fnBusquedaDt(pCdRemesa);
		
		List<String> vListaErrores= new ArrayList<String>();
		try {
			if(vCoreRemesa.size()>0) {
				File vArchivoCargado= new File(vDirectorioArchivo);
				if(vArchivoCargado.exists()) {
					List<CoreAliadoArchivo> coreAliadoArchivo=
							coreAliadoArchivoRepo.fnBusquedaDt(pCdALiado );
					if(coreAliadoArchivo.size()>0) {
						List<CoreEstructuraRemesa> vEstructuraAliado=
								coreEstructuraRemesaRepo.fnEstructururaInserta(pCdALiado,"1");
						if(vEstructuraAliado.size()>1) {
							vListaErrores=this.fnLecturaArchivo(vArchivoCargado,pCdRemesa,vEstructuraAliado);
							
							vListaErrores=fnValidacionClientes(pCdALiado, pCdRemesa, vListaErrores);
						}else {
							vListaErrores.add("No existe estructura de archivo para el codigo de aliado "+pCdALiado);
						}
						
					}else {
						vListaErrores.add("No existe parametrizacion para el codigo de aliado "+pCdALiado);
					}
				}else {
					vListaErrores.add("No existe el archivo cargado.");
				}
			}else {
				vListaErrores.add("No existe la Remesa.");
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return vListaErrores;
	}
	
	public List<String> fnLecturaArchivo(File vDirectorioArchivo,
			String pCdRemesa,
			List<CoreEstructuraRemesa> vEstructuraAliado){
		List<CoreGestionRemesa> vClientesRemesa= new ArrayList<CoreGestionRemesa>();
		CoreRemesaPojo vRemesa=coreRemesaRepo.fnPorCodigo(pCdRemesa);
		List<String> vErrores=new ArrayList<String>();
		try {
			FileInputStream vFlujolectura= new FileInputStream(vDirectorioArchivo);
			XSSFWorkbook vAPILecturaXLSX = new XSSFWorkbook(vFlujolectura);
			XSSFSheet vHojaXLSX = vAPILecturaXLSX.getSheetAt(0);
			Long vCantidadFilas=Long.valueOf(vHojaXLSX.getLastRowNum());
			String vDetalleProducto=utilesServices.fnRetornarValoresSQL("va_dato1 value, de_dato text", "tablainformacion", "cd_tabla=410094 and va_dato1="+vRemesa.getCdaliado()).get(0).split("-")[1];
			vRemesa.setNuregistrosestimados(vCantidadFilas);
			SimpleDateFormat vFormato= new SimpleDateFormat("dd-MM-yyyy");
			String vFechaConFormato=vFormato.format(vRemesa.getFeremesa());
			vRemesa.setNmremesa(vCantidadFilas+" Registros del Aliado "+vDetalleProducto+" Fecha: "+vFechaConFormato);
			coreRemesaRepo.save(vRemesa);
			CoreGestionRemesa vCliente=null;
			
			for(int indice=1;indice<=vCantidadFilas;indice++) {
				vCliente=new CoreGestionRemesa();
				for(CoreEstructuraRemesa obj:vEstructuraAliado) {
					Cell vCelda= vHojaXLSX.getRow(indice).getCell(obj.getNucolumnainicio().intValue());
					if(vCelda==null) {
						vErrores.add("El campo "+obj.getTxnombrecampo()+" está Vacío en la línea # "+ indice);
					}else {
						Method vMetodo=null;
						String vValidacionDato="";
						if(vCelda.getCellType()==CellType.STRING) {
							vValidacionDato=utilesServices.fnRetornaValorValidado(
									vCelda.getRichStringCellValue().toString(),obj.getCdvalidacion(),obj.getCdvalidacion2(),obj.getTxvaloresreemplazo());
							vMetodo=vCliente.getClass().getMethod(obj.getTxnombrepojo(),String.class);
							vMetodo.invoke(vCliente,vValidacionDato);
						}
						if(vCelda.getCellType()==CellType.NUMERIC) {
							vValidacionDato=utilesServices.fnRetornaValorValidado(
									vCelda.toString(),obj.getCdvalidacion(),obj.getCdvalidacion2(),obj.getTxvaloresreemplazo());
							vMetodo=vCliente.getClass().getMethod(obj.getTxnombrepojo(),String.class);
							vMetodo.invoke(vCliente,vValidacionDato);

						}
						if(vCelda.getCellType()==CellType.FORMULA) {
							vValidacionDato=utilesServices.fnRetornaValorValidado(
									vCelda.getRichStringCellValue().toString(),obj.getCdvalidacion(),obj.getCdvalidacion2(),obj.getTxvaloresreemplazo());
							vMetodo=vCliente.getClass().getMethod(obj.getTxnombrepojo(),String.class);
							vMetodo.invoke(vCliente,vValidacionDato);
						}
						if(vCliente.getNutelefonohab()==null) {}else {
							vCliente=utilesServices.fnValidarNumeroTelefonico(vCliente, vCliente.getNutelefonohab(), "");
						}
						if(vCliente.getNudocumento()==null) {}else {
							if(utilesServices.fnValidarDocumentoSinLetras(vCliente.getNudocumento())==0L) {
								vCliente.setStgestionremesa(88L);
								vCliente.setNudocumento("0");
								vCliente.setInduplicado(1L);
							}
						}
						
						vCliente.setCdremesa(Long.valueOf(pCdRemesa));
						
						vClientesRemesa.add(vCliente);
					}
				}
			}
			vAPILecturaXLSX.close();
			vFlujolectura.close();
		} catch (Exception e) {
			vRemesa.setStremesa(99L);
			coreRemesaRepo.save(vRemesa);
			e.printStackTrace();
		}
		coreGestionRemesaRepo.saveAll(vClientesRemesa);
		return vErrores;
	}
	public List<String> fnValidacionClientes(String pCdAliado, String pCdRemesa, List<String> vErrores) {
		CoreRemesaPojo  coreRemesaPojo=new CoreRemesaPojo();
		String vCorreo="";
		try {
			coreRemesaPojo=coreRemesaRepo.fnPorCodigo( pCdRemesa );
			if(coreRemesaPojo.getStremesa()==99L) {
				
			}else {
				List<CoreGestionRemesa> vListaCoreGestionRemesa= 
				coreGestionRemesaRepo.fnRetornarDetalleRemesa(pCdRemesa);
				if(vListaCoreGestionRemesa.size()>0) {
					for(CoreGestionRemesa obj:vListaCoreGestionRemesa) {
						if(utilesServices.fnValidaFormatoFecha(obj.getFenacimiento())==false) {
							obj.setFenacimiento("01-01-1900");
							vErrores.add("El campo fecha de nacimiento no cumple para la data con C.I: "+obj.getNudocumento());
						}
						if(utilesServices.fnValidaNumero(obj.getNuedad())==false) {
							obj.setNuedad("0.0");
							vErrores.add("El campo edad no cumple para la data con C.I: "+obj.getNudocumento());
						}
						
						if(obj.getCorreocrudo()==null) {obj.setInvalidacorreo(0L);
						}else {
							
							vCorreo=
							utilesServices.fnValidarCorreo(obj.getCorreocrudo().toUpperCase());
							
							if(vCorreo.length()>0) {
								Long vValidacionCorreoSecundaria=utilesServices.
										fnValidarCorreoModificado(vCorreo);
								
								if(vValidacionCorreoSecundaria==1L) {
									obj.setTxcorreo(vCorreo);
								}
								obj.setInvalidacorreo(vValidacionCorreoSecundaria);
								
								//System.out.println(obj);
							}else {
								obj.setInvalidacorreo(0L);
							}
							if(obj.getCorreocrudo().toUpperCase().equalsIgnoreCase(vCorreo.toUpperCase())) {}
							else {
								vErrores.add("Se Realizó un cambio de correo de "+obj.getCorreocrudo()+" a "+vCorreo);
							}
							
						}
						if(pCdAliado.equals("11")) {
							if( obj.getNombrecrudo()==null) {obj.setInvalidaprimernombre(0L);obj.setInvalidaprimernombre(0L);
							}else {
								utilesServices.fnValidarNombreArchivo100x100(obj, obj.getNombrecrudo(), aValidacionNombres, aValidacionNombresArr);
								if(obj.getNmnombre1()==null) {obj.setInvalidaprimernombre(0L);}
								if(obj.getNmapellido1()==null) {obj.setInvalidaprimerapellido(0L); vErrores.add("Existencia de Nombre Compuesto para "+obj.getNombrecrudo());}
								}
						}else {
							
						}
						obj.setInvalidafechanacimiento(0L);
						obj.setInvalidaprimerapellido(0L);
						obj.setInvalidanudocumento(0L);
						obj.setInvalidaprimernombre(0L);
						obj.setInvalidatelefonolocal(0L);
						obj.setInvalidatelefonomovil(0L);
						coreGestionRemesaRepo.save(obj);
					}
				}
				
				coreRemesaPojo.setStremesa(3L);
				coreGestionRemesaRepo.fnMarcarDuplicadosEnElArchivo(pCdRemesa);
				coreGestionRemesaRepo.fnActualizarPrimerRegistroMarcadoDuplicado(pCdRemesa);
				coreGestionRemesaRepo.fnActualizarDuplicadosSIR(pCdRemesa); 
				coreGestionRemesaRepo.fnActualizarRemesa(pCdRemesa);
				coreRemesaRepo.save(coreRemesaPojo);
				coreGestionRemesaRepo.fnActualizarRemesaNoOptima(pCdRemesa);
				coreGestionRemesaRepo.fnActualizarRemesaConDuplicados(pCdRemesa);
				vErrores.add("El proceso de validación de negocio se realizó con éxito.");
			}
		} catch (Exception e) {
			vErrores.add("SLF-ERROR(03): Error en proceso validación de negocio "+e.getLocalizedMessage());
			//coreGeneradorLog.fnGenerarArregloLog(vErrores, pCoreOrdenes);
		}
		return vErrores;
		
	}
}
