package ve.org.others.services.rest;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.Resource;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;

import ve.org.others.services.logica.GeneracionCorreo;
import ve.org.others.services.logica.GeneracionDeReportes;

@RestController
public class Rest {
	@Autowired
	private GeneracionDeReportes generacionDeReportes;
	@Autowired
	private GeneracionCorreo generacionCorreo;
	
	@GetMapping("sgd.reportes-xlsx/{pNombreArchivo}/{pParametros}")
	public ResponseEntity<Resource> fnServicioReportes(@PathVariable(value = "pNombreArchivo") String pNombreArchivo,@PathVariable(value = "pParametros") String pParametros ){
		ResponseEntity<Resource> vRetorno=null;
		try {
			 vRetorno=generacionDeReportes.fnGenerarReportesXlsx(pNombreArchivo, pParametros);
		} catch (Exception e) {
			e.printStackTrace();
		} 
		return vRetorno;
	}

	@GetMapping("sgd.logs/{pCdRemesa}")
	public ResponseEntity<Resource> fnServicioLogs(@PathVariable(value = "pCdRemesa") String pCdRemesa ){
		ResponseEntity<Resource> vRetorno=null;
		try {
			 vRetorno=generacionDeReportes.fnGenerarLog(pCdRemesa);
		} catch (Exception e) {
			e.printStackTrace();
		} 
		return vRetorno;
	}
	
	@PostMapping("sgd.envio-correo")
	public void fnEnvioCorreo(@RequestBody SolicitudCorreo vParametroCorreo){
		generacionCorreo.fnEnviarCorreo(vParametroCorreo);
	}
	
	
	
}
