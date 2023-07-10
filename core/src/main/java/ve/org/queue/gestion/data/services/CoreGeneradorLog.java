package ve.org.queue.gestion.data.services;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;

import ve.org.queue.gestion.data.pojos.CoreRemesaPojo;
import ve.org.queue.gestion.data.repos.CoreRemesaRepo;

@Service
public class CoreGeneradorLog {
	
	
	@Value("${core.directorio.logs}")
	private String aPathLog;
	
	@Autowired
	private CoreRemesaRepo coreRemesaRepo;
	
	public void fnGenerarArregloLog(List<String> vErrores,String pCdRemesa ) {
		try {
			File vLog= new File(aPathLog+"SGD_CARGA-"+pCdRemesa+
					".txt");
			FileWriter vEscritor=new FileWriter(vLog);
			BufferedWriter vFlujoEscritura= new BufferedWriter(vEscritor);
			for(String vError:vErrores) {
				vFlujoEscritura.append(vError);
				vFlujoEscritura.newLine();
			}
			vFlujoEscritura.close();
			vEscritor.close();
			CoreRemesaPojo coreRemesaPojo=coreRemesaRepo.fnPorCodigo(pCdRemesa);
			coreRemesaPojo.setTxlogremesa(vLog.getAbsolutePath());
			coreRemesaRepo.save(coreRemesaPojo);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

}
