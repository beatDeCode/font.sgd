/*package ve.org.queue.gestion.data.services;

import java.io.File;
import java.io.FileInputStream;
import java.lang.reflect.Method;
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
import ve.org.queue.gestion.data.repos.CoreOrdenesRepo;
import ve.org.queue.gestion.data.repos.CoreRemesaRepo;

@Service
public class CoreLectorArchivoCorreos {
	
	
	@Value("${core.directorio.logs}")
	private String aPathLog;
	
	@Autowired
	private CoreGestionRemesaRepo coreGestionRemesaRepo;
	
	@Autowired
	private CoreOrdenesRepo coreOrdenesRepo;
	
	@Autowired
	private UtilesServices utilesServices;
	
	@Autowired
	private CoreAliadoArchivoRepo coreAliadoArchivoRepo;
	
	@Autowired
	private CoreRemesaRepo coreRemesaRepo;
	
	@Autowired
	private CoreEstructuraRemesaRepo coreEstructuraRemesaRepo;
	

	
	public List<String> fnDesglosaArchivoComun(CoreOrdenes pCoreOrdenes,List<String> vErrores) {
		
		CoreRemesaPojo coreRemesaPojo=new CoreRemesaPojo();
		coreRemesaPojo=coreRemesaRepo.fnPorCodigo(Long.valueOf(pCoreOrdenes.getParametro3()));	
		String vLineaError="";
		try {
			File vCargaArchivo= new File(
					pCoreOrdenes.getTxdirectoriodescarga()
					);
			if(vCargaArchivo.exists()) {
				FileInputStream vFlujolectura= new FileInputStream(vCargaArchivo);
				XSSFWorkbook vAPILecturaXLSX = new XSSFWorkbook(vFlujolectura);
				int vNumeroHojas=vAPILecturaXLSX.getNumberOfSheets();
				List<CoreEstructuraRemesa> listCoreEstructuraRemesa=new ArrayList<>();
				listCoreEstructuraRemesa=coreEstructuraRemesaRepo.fnEstructururaInserta("100","4");
				CoreGestionRemesa vIntegrantesRemesa=null;
					if(vNumeroHojas>0) {
						XSSFSheet vHojaXLSX = vAPILecturaXLSX.getSheetAt(0);
						int vCantidadFilas = vHojaXLSX.getLastRowNum();
						//coreRemesaPojo.setNuregistrosestimados(Long.valueOf(vCantidadFilas));
						if(vCantidadFilas>1) {
							for(int indice=1;indice<=vCantidadFilas;indice++) {
								vIntegrantesRemesa= new CoreGestionRemesa();
								for(CoreEstructuraRemesa obj:listCoreEstructuraRemesa) {
									Cell vCelda= vHojaXLSX.getRow(indice).getCell(obj.getNucolumnainicio().intValue());
									if(vCelda==null) {
										vErrores.add("El campo "+obj.getTxnombrecampo()+" está Vacío en la línea # "+ indice);
									}else {
										vLineaError="Valor: "+vCelda+" Linea: "+indice+" Campo:"+obj.getTxnombrecampo();
										Method vMetodo=null;
										String vValidacionDato="";
										if(vCelda.getCellType()==CellType.STRING) {
											vValidacionDato=utilesServices.fnRetornaValorValidado(
													vCelda.getRichStringCellValue().toString(),obj.getCdvalidacion(),obj.getCdvalidacion2(),obj.getTxvaloresreemplazo());
											vMetodo=vIntegrantesRemesa.getClass().getMethod(obj.getTxnombrepojo(),String.class);
											vMetodo.invoke(vIntegrantesRemesa,vValidacionDato);
										}
										if(vCelda.getCellType()==CellType.NUMERIC) {
											vValidacionDato=utilesServices.fnRetornaValorValidado(
													vCelda.toString(),obj.getCdvalidacion(),obj.getCdvalidacion2(),obj.getTxvaloresreemplazo());
											vMetodo=vIntegrantesRemesa.getClass().getMethod(obj.getTxnombrepojo(),String.class);
											vMetodo.invoke(vIntegrantesRemesa,vValidacionDato);

										}
										if(vCelda.getCellType()==CellType.FORMULA) {
											vValidacionDato=utilesServices.fnRetornaValorValidado(
													vCelda.getRichStringCellValue().toString(),obj.getCdvalidacion(),obj.getCdvalidacion2(),obj.getTxvaloresreemplazo());
											vMetodo=vIntegrantesRemesa.getClass().getMethod(obj.getTxnombrepojo(),String.class);
											vMetodo.invoke(vIntegrantesRemesa,vValidacionDato);
										}
									}
									if(vIntegrantesRemesa.getNutelefonohab()==null) {}else {
										vIntegrantesRemesa=utilesServices.fnValidarNumeroTelefonico(vIntegrantesRemesa, vIntegrantesRemesa.getNutelefonohab(), "");
									}
									vIntegrantesRemesa.setCdremesa(Long.valueOf(pCoreOrdenes.getParametro3()));
									vIntegrantesRemesa.setStgestionremesa(80L);
									coreGestionRemesaRepo.save(vIntegrantesRemesa);	
								}
								

							}
							coreRemesaPojo.setStremesa(80L);
							vErrores.add("");	
							List <String> vMaxConsecutivoPorAliado=
							utilesServices.fnRetornarValoresSQL("nvl(max(nu_consecutivo_remesa),0)+1, 0 id", "interface.coreremesa", "cd_aliado="+pCoreOrdenes.getParametro1());
							coreRemesaPojo.setNuconsecutivoremesa(Long.valueOf(vMaxConsecutivoPorAliado.get(0).split("-")[0]));
							coreRemesaRepo.save(coreRemesaPojo);
							
							vAPILecturaXLSX.close();
							vFlujolectura.close();
						}else {
							//coreRemesaPojo.setStremesa(99L);
							coreRemesaRepo.save(coreRemesaPojo);
							pCoreOrdenes.setStorden(3L);
							vErrores.add("El archivo "+pCoreOrdenes.getTxnombrearchivo()+" está vacío.");
						}
						vFlujolectura.close();
					}else {
			
						coreRemesaPojo.setStremesa(99L);
						coreRemesaRepo.save(coreRemesaPojo);
						pCoreOrdenes.setStorden(2L);
						vErrores.add("El archivo "+pCoreOrdenes.getTxnombrearchivo());
					}
				}	
			vErrores.add("Culminó el proceso de carga con éxito.s");
		} catch (Exception e) {
			coreRemesaPojo.setStremesa(99L);
			coreRemesaRepo.save(coreRemesaPojo);
			vErrores.add("SLF-ERROR(04): Error en proceso de carga de datos. "+e.getLocalizedMessage()+" "+vLineaError);
			pCoreOrdenes.setParametro5(e.getLocalizedMessage());
			pCoreOrdenes.setStorden(99L);
			coreOrdenesRepo.save(pCoreOrdenes);
			e.printStackTrace();
		}
		return vErrores;
		
	}

}*/
