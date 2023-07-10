package ve.org.queue.gestion.data.services;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.util.LinkedMultiValueMap;
import org.springframework.util.MultiValueMap;
import org.springframework.web.client.RestTemplate;

import ve.org.queue.gestion.data.pojos.CoreGestionRemesa;
import ve.org.queue.gestion.data.pojos.CoreRemesaPojo;
import ve.org.queue.gestion.data.repos.CoreGestionRemesaRepo;
import ve.org.queue.gestion.data.repos.CoreRemesaRepo;

@Service
public class CoreValidacionesExternas {
	
	
	@Value("${core.url.ivss}")
	private String aURLIvss;
	
	@Autowired
	private CoreGestionRemesaRepo coreGestionRemesaRepo;
	
	@Autowired
	private CoreRemesaRepo coreRemesaRepo;
	
	public List<String> fnValidaClienteIVSS(String pCdRemesa,List<String> vErrores) {
		
		int vCantidadCaractes=0;
		try {
			System.out.println("Iniciando IVSS");
			List<CoreGestionRemesa> vLista=
			coreGestionRemesaRepo.fnRetornarRemesaConErroresEnFechaNacimiento(pCdRemesa);
			String vResultado="";
			RestTemplate restTemplate= new RestTemplate();
			HttpHeaders headers = new HttpHeaders();
			headers.setContentType(MediaType.APPLICATION_FORM_URLENCODED);
			for(CoreGestionRemesa obj:vLista) {
				if(obj.getFenacimiento().isEmpty()) {}else {
					if(obj.getFenacimiento().split("-").length>0) {
						
						String [] vFechaNacimiento= obj.getFenacimiento().split("-");
						MultiValueMap<String, String> map= new LinkedMultiValueMap<String, String>();
						map.add("nacionalidad_aseg", obj.getTpdocumento());
						map.add("cedula_aseg", obj.getNudocumento());
						map.add("d", String.valueOf(Integer.parseInt(vFechaNacimiento[0])) );
						map.add("m", String.valueOf(Integer.parseInt(vFechaNacimiento[1])) );
						map.add("y", String.valueOf(Integer.parseInt(vFechaNacimiento[2])) );
						
						HttpEntity<MultiValueMap<String, String>> request = new HttpEntity<MultiValueMap<String, String>>(map, headers);
						ResponseEntity<String> response = restTemplate.postForEntity( aURLIvss, request , String.class );
						vCantidadCaractes=response.getBody().replace("", "\n").trim().length();
						vResultado="IVSS-INFO: Se enviaron los datos. Cedula:"+obj.getTpdocumento()+"-"+obj.getNudocumento()+", Fecha Nacimiento: "+obj.getFenacimiento();
						if(vCantidadCaractes>3000) {
							obj.setInivssvalidacion(1L);
							coreGestionRemesaRepo.save(obj);
							vResultado+=" y se validó con éxito.";
						}else {
							vResultado+=" y no existe.";
						}
					}
				}
			}
			coreGestionRemesaRepo.fnActualizarRemesaIvss(pCdRemesa);
			CoreRemesaPojo coreRemesaPojo=new CoreRemesaPojo();
			coreRemesaPojo=coreRemesaRepo.fnPorCodigo(pCdRemesa);
			coreRemesaPojo.setStvalidacionivss(1L);
			coreRemesaRepo.save(coreRemesaPojo);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return vErrores;	
	}
}
