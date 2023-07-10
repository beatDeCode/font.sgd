package com.ve.gestiondata.mailcore.servicios;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.scheduling.annotation.EnableScheduling;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.stereotype.Service;
import com.ve.gestiondata.mailcore.pojos.CoreOrdenes;
import com.ve.gestiondata.mailcore.repos.CoreOrdenesRepo;

@Service
@EnableScheduling
public class ColaDeProcesoCorreo {
	
	@Autowired
	private GestionDeCorreo gestionDeCorreo;
	
	@Autowired
	private GestionReportesPDF gestionReportesPDF;
	
	@Autowired
	private CoreOrdenesRepo coreOrdenesRepo;

	@Value("${core.cola.ejecucion}")
	private String vNumeroCola;
	
	@Scheduled(fixedDelay = 5000)
	public void procesoPrincipalCola() {
		CoreOrdenes coreOrdenes=new CoreOrdenes();
		List<CoreOrdenes> vListCoreOrdenes=coreOrdenesRepo.fnRetornaOrden(Long.valueOf(vNumeroCola));
		try {
			if(vListCoreOrdenes.size()>0) {
				coreOrdenes=vListCoreOrdenes.get(0);
				if(coreOrdenes.getCdprograma()==2) {
					System.out.println("Inciando proceso Generacion de PDF");
					gestionReportesPDF.FnGenerarReporteSolicitudSeguros(coreOrdenes.getParametro1());
					System.out.println("Inciando proceso Envios de correos");
					gestionDeCorreo.fnEnviarCorreo(
							coreOrdenes.getParametro1(),
							coreOrdenes.getParametro2(),
							coreOrdenes.getParametro3()
							);
					coreOrdenes.setStorden(3L);
					coreOrdenesRepo.save(coreOrdenes);
					System.out.println("Culminó proceso");
				}
				if(coreOrdenes.getCdprograma()==12) {
					System.out.println("Inciando proceso Generacion de PDF");
					gestionReportesPDF.FnGenerarReporteSolicitudSeguros(coreOrdenes.getParametro1());
					System.out.println("Inciando proceso Envios de correos");
					gestionDeCorreo.fnEnviarCorreo(
							coreOrdenes.getParametro1(),
							coreOrdenes.getParametro2(),
							coreOrdenes.getParametro3()
							);
					coreOrdenes.setStorden(3L);
					coreOrdenesRepo.save(coreOrdenes);
					System.out.println("Culminó proceso");
				}
				/*if(coreOrdenes.getCdPrograma()==3) {
					System.out.println("Inciando proceso Generacion de PDF Solicitud Extra");
					gestionReportesPDF.FnGenerarReporteSolicitudSegurosExtra(coreOrdenes.getParametro1());
					System.out.println("Inciando proceso Envios de correos");
					gestionDeCorreo.fnEnviarCorreoSSExtra(coreOrdenes.getParametro1());
					coreOrdenes.setStOrden(3L);
					coreOrdenesRepo.save(coreOrdenes);
					System.out.println("Culminó proceso");
				}
				if(coreOrdenes.getCdPrograma()==4) {
					System.out.println("Iniciado proceso Correo Informativo");
					gestionDeCorreo.fnEnviarCorreoSSExtraInformativo(coreOrdenes.getParametro1());
					coreOrdenes.setStOrden(3L);
					coreOrdenesRepo.save(coreOrdenes);
					System.out.println("Culminó proceso");
				}*/
				if(coreOrdenes.getCdprograma()==4) {
					System.out.println("Inciando proceso Generacion de PDF Emision Masiva");
					gestionReportesPDF.fnGeneraReporteEmision(coreOrdenes.getParametro1());
					System.out.println("Inciando proceso Envios de correos");
					gestionDeCorreo.fnEnviarCorreoEmision(coreOrdenes.getParametro1());
					coreOrdenes.setStorden(3L);
					coreOrdenesRepo.save(coreOrdenes);
					System.out.println("Culminó proceso");
				}
				if(coreOrdenes.getCdprograma()==14) {
					System.out.println("Inciando proceso Generacion de PDF");
					gestionReportesPDF.FnGenerarReporteSolicitudSeguros(coreOrdenes.getParametro1());
					System.out.println("Inciando proceso Envios de correos");
					gestionDeCorreo.fnEnviarCorreo(
							coreOrdenes.getParametro1(),
							coreOrdenes.getParametro2(),
							coreOrdenes.getParametro3()
							);
					coreOrdenes.setStorden(3L);
					coreOrdenesRepo.save(coreOrdenes);
					System.out.println("Culminó proceso");
				}
				
			}
			
		} catch (Exception e) {
			coreOrdenes.setStorden(2L);
			//coreOrdenes.setParametro5(e.getLocalizedMessage());
			coreOrdenesRepo.save(coreOrdenes);
			e.printStackTrace();
		}
		
	}

}
