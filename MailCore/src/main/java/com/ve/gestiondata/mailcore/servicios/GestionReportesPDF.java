package com.ve.gestiondata.mailcore.servicios;

import java.io.File;
import java.sql.Connection;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import javax.sql.DataSource;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;

import com.ve.gestiondata.mailcore.pojos.CoreGestionRemesa;
import com.ve.gestiondata.mailcore.pojos.CoreProcesoTecnico;
import com.ve.gestiondata.mailcore.repos.CoreGestionRemesaRepo;
import com.ve.gestiondata.mailcore.repos.CoreProcesoCampaniaRepo;
import com.ve.gestiondata.mailcore.repos.CoreProcesoTecnicoRepo;

import net.sf.jasperreports.engine.JasperExportManager;
import net.sf.jasperreports.engine.JasperFillManager;
import net.sf.jasperreports.engine.JasperPrint;
import net.sf.jasperreports.engine.export.JRPdfExporter;
import net.sf.jasperreports.export.SimpleExporterInput;
import net.sf.jasperreports.export.SimpleOutputStreamExporterOutput;

@Service
public class GestionReportesPDF {
	@Autowired
    protected DataSource dataSource;
	
	@Value("${core.directorio.salida.reportes}")
	private String aPathSalida; 
	@Value("${core.reporte.solicitudseguros}")
	private String aCompiladoSolicitudSeguros;
	@Value("${core.reporte.cuadropoliza}")
	private String aCompiladoCuadropoliza;
	@Value("${core.directorio.compilados}")
	private String aPathCompilados;
	
	@Autowired
	private CoreProcesoTecnicoRepo coreProcesoTecnicoRepo;
	@Autowired
	private CoreGestionRemesaRepo coreGestionRemesaRepo;
	@Autowired
	private CoreProcesoCampaniaRepo coreProcesoCampaniaRepo;
	
	
	public void FnGenerarReporteSolicitudSeguros(String pCdProcesoTecnico) {
		
		try {
			String vNombreDelReporte="";
			List<CoreGestionRemesa> vListaCoreGestionRemesa=coreGestionRemesaRepo.
					fnBuscarPolizasPendientesParaEnvioDeSS(pCdProcesoTecnico,"4");
			CoreProcesoTecnico coreProcesoTecnico=new CoreProcesoTecnico();
			coreProcesoTecnico=coreProcesoTecnicoRepo.fnBuscarProcesoTecnicoEnProcesoUni(pCdProcesoTecnico);
			coreProcesoTecnico.setInsolicitudseguros(2L);
			coreProcesoTecnicoRepo.save(coreProcesoTecnico);
			Connection connection = dataSource.getConnection();
			if(vListaCoreGestionRemesa.size()>0) {
				for(CoreGestionRemesa obj:vListaCoreGestionRemesa) {
					//System.out.println("Correo, "+obj.getCorreocrudo());
					HashMap<String, Object> parametros= new HashMap<String, Object>();
					parametros.put("CD_GESTION_REMESA", obj.getCdgestionremesa());
					
			    	JasperPrint vImpresionReporte = JasperFillManager.fillReport(
			    			aPathCompilados+
			    			aCompiladoSolicitudSeguros, 
			    			parametros,
			    			connection);
			    	vNombreDelReporte=aCompiladoSolicitudSeguros.replace(".jasper", "")+"_"+obj.getCdgestionremesa()+".pdf";
			    	JRPdfExporter vExportadorDeArchivo = new JRPdfExporter();
					JasperExportManager.exportReportToPdfFile(vImpresionReporte,
							aPathSalida+vNombreDelReporte);
					vExportadorDeArchivo.setExporterInput(new SimpleExporterInput(vImpresionReporte));
					vExportadorDeArchivo.setExporterOutput(new SimpleOutputStreamExporterOutput(
							new File(aPathSalida+vNombreDelReporte)));
					vExportadorDeArchivo.exportReport();
					coreGestionRemesaRepo.save(obj);
				}
			}else {
			
			}
			connection.close();
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	
	public void FnGenerarReporteSolicitudSegurosCampania(String pCdProcesoTecnico) {
		
		try {
			String vNombreDelReporte="";
			List<CoreGestionRemesa> vListaCoreGestionRemesa=coreGestionRemesaRepo.
					fnBuscarPolizasPendientesParaEnvioDeSSCampania(pCdProcesoTecnico,"4");
			CoreProcesoTecnico coreProcesoTecnico=new CoreProcesoTecnico();
			coreProcesoTecnico=coreProcesoCampaniaRepo.fnBuscarProcesoTecnicoEnProcesoUni(pCdProcesoTecnico);
			coreProcesoTecnico.setInsolicitudseguros(2L);
			coreProcesoTecnicoRepo.save(coreProcesoTecnico);
			Connection connection = dataSource.getConnection();
			if(vListaCoreGestionRemesa.size()>0) {
				for(CoreGestionRemesa obj:vListaCoreGestionRemesa) {
					//System.out.println("Correo, "+obj.getCorreocrudo());
					HashMap<String, Object> parametros= new HashMap<String, Object>();
					parametros.put("CD_GESTION_REMESA", obj.getCdgestionremesa());
					
			    	JasperPrint vImpresionReporte = JasperFillManager.fillReport(
			    			aPathCompilados+
			    			aCompiladoSolicitudSeguros, 
			    			parametros,
			    			connection);
			    	vNombreDelReporte=aCompiladoSolicitudSeguros.replace(".jasper", "")+"_"+obj.getCdgestionremesa()+".pdf";
			    	JRPdfExporter vExportadorDeArchivo = new JRPdfExporter();
					JasperExportManager.exportReportToPdfFile(vImpresionReporte,
							aPathSalida+vNombreDelReporte);
					vExportadorDeArchivo.setExporterInput(new SimpleExporterInput(vImpresionReporte));
					vExportadorDeArchivo.setExporterOutput(new SimpleOutputStreamExporterOutput(
							new File(aPathSalida+vNombreDelReporte)));
					vExportadorDeArchivo.exportReport();
					coreGestionRemesaRepo.save(obj);
				}
			}else {
			
			}
			connection.close();
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	public void fnGeneraReporteEmision(String pCdProcesoTecnico) {
		try {
			String vNombreDelReporte="";
			List<CoreGestionRemesa> vListaCoreGestionRemesa=coreGestionRemesaRepo.fnBuscarCuadroPolizasPendientes(pCdProcesoTecnico,"4");
			CoreProcesoTecnico coreProcesoTecnico=new CoreProcesoTecnico();
			coreProcesoTecnico=coreProcesoTecnicoRepo.fnBuscarProcesoTecnicoEnProcesoUni(pCdProcesoTecnico);
			coreProcesoTecnico.setInenviocuadropoliza(2L);
			coreProcesoTecnicoRepo.save(coreProcesoTecnico);
			Connection connection = dataSource.getConnection();
			if(vListaCoreGestionRemesa.size()>0) {
				for(CoreGestionRemesa obj:vListaCoreGestionRemesa) {
					HashMap<String, Object> parametros= new HashMap<String, Object>();
					parametros.put("NU_POLIZA", obj.getNupoliza());
			    	JasperPrint vImpresionReporte = JasperFillManager.fillReport(
			    			aPathCompilados+
			    			aCompiladoCuadropoliza, 
			    			parametros,
			    			connection);
			    	
			    	vNombreDelReporte=aCompiladoCuadropoliza.replace(".jasper", "")+"_"+obj.getCdgestionremesa()+".pdf";
			    	JRPdfExporter vExportadorDeArchivo = new JRPdfExporter();
					JasperExportManager.exportReportToPdfFile(vImpresionReporte,
							aPathSalida+vNombreDelReporte);
					vExportadorDeArchivo.setExporterInput(new SimpleExporterInput(vImpresionReporte));
					vExportadorDeArchivo.setExporterOutput(new SimpleOutputStreamExporterOutput(
							new File(aPathSalida+vNombreDelReporte)));
					vExportadorDeArchivo.exportReport();
					//obj.setInenviosolicitudseguros(2L);
					//coreGestionRemesaRepo.save(obj);
				}
			}
			connection.close();
			
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public void FnGenerarReporteSolicitudSegurosExtra(String pCdRemesa) {
		try {
			String vNombreDelReporte="";
			List<CoreGestionRemesa> vListaCoreGestionRemesa=coreGestionRemesaRepo.fnBuscarPolizasPendientesParaEnvioDeSS(pCdRemesa,"70");
			Connection connection = dataSource.getConnection();
			if(vListaCoreGestionRemesa.size()>0) {
				for(CoreGestionRemesa obj:vListaCoreGestionRemesa) {
					HashMap<String, Object> parametros= new HashMap<String, Object>();
					parametros.put("CD_GESTION_REMESA", obj.getCdgestionremesa());
					
			    	JasperPrint vImpresionReporte = JasperFillManager.fillReport(
			    			aPathCompilados+
			    			aCompiladoSolicitudSeguros, 
			    			parametros,
			    			connection);
			    	vNombreDelReporte=aCompiladoSolicitudSeguros.replace(".jasper", "")+"_"+obj.getCdgestionremesa()+".pdf";
			    	JRPdfExporter vExportadorDeArchivo = new JRPdfExporter();
					JasperExportManager.exportReportToPdfFile(vImpresionReporte,
							aPathSalida+vNombreDelReporte);
					vExportadorDeArchivo.setExporterInput(new SimpleExporterInput(vImpresionReporte));
					vExportadorDeArchivo.setExporterOutput(new SimpleOutputStreamExporterOutput(
							new File(aPathSalida+vNombreDelReporte)));
					vExportadorDeArchivo.exportReport();
					//obj.setInenviosolicitudseguros(2L);
					coreGestionRemesaRepo.save(obj);
				}
			}
			connection.close();
			
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	

}
