package ve.org.others.services.logica;

import java.io.File;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.sql.Connection;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;

import javax.sql.DataSource;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.core.io.ByteArrayResource;
import org.springframework.core.io.Resource;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;

import net.sf.jasperreports.engine.JasperFillManager;
import net.sf.jasperreports.engine.JasperPrint;
import net.sf.jasperreports.engine.export.ooxml.JRXlsxExporter;
import net.sf.jasperreports.export.SimpleExporterInput;
import net.sf.jasperreports.export.SimpleOutputStreamExporterOutput;
import net.sf.jasperreports.export.SimpleXlsxReportConfiguration;

@Service
public class GeneracionDeReportes {
	
	@Autowired
    protected DataSource dataSource;
	
	@Value("${core.directorio.compilados}")
	private String aPathCompilados;
	
	@Value("${core.directorio.salida}")
	private String aPathSalidaReportes;
	
	@Value("${core.directorio.logs}")
	private String aPathLog;
	
	
	public ResponseEntity<Resource> fnGenerarReportesXlsx(String pNombreCompilado, String pParametros) {
		Path vRuta = null;
	    ByteArrayResource vArchivoRetorno = null;
	    File archivoExportado=null;
	    String vNombreDelReporte="";
	    try {
	    	SimpleDateFormat vFormatoFecha=new SimpleDateFormat("dd-MM-yy");
	    	String vFechaExtraccion=vFormatoFecha.format(new Date());
	    	
	    	HashMap<String, Object> vParametrosReporte= new HashMap<String, Object>();
	    	String [] vArray=new String[pParametros.split("-").length];
	    	vArray=pParametros.split("-");
	    	for(int indice=0;indice<vArray.length;indice++) {
	    		if( (indice+1)%2==0 ) {
	    			vParametrosReporte.put(vArray[indice-1], vArray[indice]);
	    		}
	    	}
	    	Connection connection = dataSource.getConnection();
	    	JasperPrint vImpresionReporte = JasperFillManager.fillReport(
	    			aPathCompilados+pNombreCompilado+".jasper", 
	    			vParametrosReporte,
	    			connection);
	    	vNombreDelReporte=pNombreCompilado+vFechaExtraccion+".xlsx";
			SimpleXlsxReportConfiguration vConfiguracionDelReporte= new SimpleXlsxReportConfiguration();
			vConfiguracionDelReporte.setDetectCellType(true);
			vConfiguracionDelReporte.setOnePagePerSheet(true);
			vConfiguracionDelReporte.setIgnoreCellBackground(false);
			vConfiguracionDelReporte.setWhitePageBackground(true);
			File vArchivoSalida= new File(
					aPathSalidaReportes+vNombreDelReporte);
			JRXlsxExporter vExportadorDeArchivo= new JRXlsxExporter();
			vExportadorDeArchivo.setExporterInput(new SimpleExporterInput(vImpresionReporte));
			vExportadorDeArchivo.setExporterOutput(new SimpleOutputStreamExporterOutput(vArchivoSalida));
			vExportadorDeArchivo.setConfiguration(vConfiguracionDelReporte);
			vExportadorDeArchivo.exportReport();
	    	archivoExportado=new File(aPathSalidaReportes+vNombreDelReporte);
	    	connection.close();
	    	
	    	vRuta = Paths.get(archivoExportado.getAbsolutePath());
	    	vArchivoRetorno = new ByteArrayResource(Files.readAllBytes(vRuta));
		} catch (Exception e) {
			e.printStackTrace();
		}
	    return ResponseEntity.ok()
	    		.header(HttpHeaders.CONTENT_DISPOSITION, "attachment;filename="+vNombreDelReporte )
	            .contentLength(archivoExportado.length())
	            .contentType(MediaType.APPLICATION_OCTET_STREAM)
	            .body(vArchivoRetorno);
		
	}
	public ResponseEntity<Resource> fnGenerarLog(String pCdRemesa) {
		Path vRuta = null;
	    ByteArrayResource vArchivoRetorno = null;
	    File archivoExportado=null;
	    String vNombreDelReporte="";
	    try {
	    	
	    	archivoExportado=new File(aPathLog+"SGD_CARGA-"+pCdRemesa+".txt");
	    	
	    	vRuta = Paths.get(archivoExportado.getAbsolutePath());
	    	vArchivoRetorno = new ByteArrayResource(Files.readAllBytes(vRuta));
		} catch (Exception e) {
			e.printStackTrace();
		}
	    return ResponseEntity.ok()
	    		.header(HttpHeaders.CONTENT_DISPOSITION, "attachment;filename="+archivoExportado.getName() )
	            .contentLength(archivoExportado.length())
	            .contentType(MediaType.APPLICATION_OCTET_STREAM)
	            .body(vArchivoRetorno);
		
	}
	
}
