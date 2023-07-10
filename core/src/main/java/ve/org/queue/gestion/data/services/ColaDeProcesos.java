package ve.org.queue.gestion.data.services;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.scheduling.annotation.EnableScheduling;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.stereotype.Service;

import ve.org.queue.gestion.data.pojos.CoreOrdenes;
import ve.org.queue.gestion.data.pojos.CoreRemesaPojo;
import ve.org.queue.gestion.data.repos.CoreOrdenesRepo;
import ve.org.queue.gestion.data.repos.CoreRemesaRepo;

@Service
@EnableScheduling
public class ColaDeProcesos {
	
	@Autowired
	private CoreOrdenesRepo coreOrdenesRepo;
	
	@Autowired
	private CoreGeneradorLog coreGeneradorLog;
	
	@Autowired
	private CoreEmisionPolizas coreEmisionPolizas;
	
	@Value("${core.cola.ejecucion}")
	private String vNumeroCola;
	
	@Autowired
	private CoreLecturaArchivoXLS coreLecturaArchivoXLS;
	
	@Scheduled(fixedDelay = 5000)
	public void procesoPrincipalCola() {
		
		List<CoreOrdenes> vListCoreOrdenes=coreOrdenesRepo.fnRetornaOrden(Long.valueOf(vNumeroCola));
		List<String> vErrores=new ArrayList<>();
		
		try {
			
			if(vListCoreOrdenes.size()>0) {
				CoreOrdenes coreOrdenes=vListCoreOrdenes.get(0);
				if(coreOrdenes.getCdprograma()==1L) {
					vErrores=coreLecturaArchivoXLS.fnLectura(coreOrdenes.getParametro1(),//Aliado
													coreOrdenes.getParametro2(),//Producto
													coreOrdenes.getParametro3(),//Remesa
													coreOrdenes.getTxdirectoriodescarga(),//Directorio
													coreOrdenes.getTxnombrearchivo());//Nombre
					coreGeneradorLog.fnGenerarArregloLog(vErrores, coreOrdenes.getParametro3());
					coreOrdenes.setStorden(3L);
					coreOrdenes.setFeordenini(new Date());
					coreOrdenes.setFeordenfin(new Date());
					coreOrdenesRepo.save(coreOrdenes);
				}
				if(coreOrdenes.getCdprograma()==3) {
					System.out.println("Inciando proceso de Emision");
					coreEmisionPolizas.fnGenerarEmision(coreOrdenes);
					System.out.println("Culminó proceso de Emision");
					coreOrdenes.setStorden(3L);
					coreOrdenesRepo.save(coreOrdenes);
				}
			}
			
			/*if(coreOrdenes.getCdprograma()==3) {
					coreLectorArchivoCorreos.fnDesglosaArchivoComun(coreOrdenes, vErrores);
					coreOrdenes.setStorden(3L);
					coreOrdenesRepo.save(coreOrdenes);
					coreGeneradorLog.fnGenerarArregloLog(vErrores, coreOrdenes);
					System.out.println("Culminó proceso");
			}*/
				
			
		} catch (Exception e) {
			e.printStackTrace();
		}
		
	}

}
