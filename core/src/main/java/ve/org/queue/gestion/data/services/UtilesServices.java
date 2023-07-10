package ve.org.queue.gestion.data.services;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.persistence.EntityManager;
import javax.persistence.PersistenceContext;
import javax.persistence.Query;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;

import ve.org.queue.gestion.data.pojos.CoreExpresionCorreoPojo;
import ve.org.queue.gestion.data.pojos.CoreGestionRemesa;
import ve.org.queue.gestion.data.repos.CoreExpresionCorreoRepo;



@Service
public class UtilesServices {	
	
	@PersistenceContext
	private EntityManager entityManager;
	
	@Autowired
	private CoreExpresionCorreoRepo coreExpresionCorreoRepo;
	
	@Value("${core.validacion.correo.direccion}")
	private String vValidacionCorreoBasico;
	@Value("${core.validacion.correo.dominio}")
	private String vValidacionDominioCorreo;

	public String fnRetornaValorValidado(String pValor,Long pCdValidacion,Long pCdValidacion2,String pReemplazos) {
		String vRetorno="";
		String [] vRetornoAux=new String [2];
		try {
			if(pCdValidacion>0L) {
				if(pCdValidacion==1L) {vRetornoAux[0]=fnConversionEntero(pValor);}
				if(pCdValidacion==2L) {vRetornoAux[0]=fnReemplazarCaracteres(pValor,pReemplazos);}
				if(pCdValidacion==3L) {vRetornoAux[0]=fnRetornarPrimerCaracter(pValor);}
				if(pCdValidacion2>0L) {
					if(pCdValidacion2==1L) {vRetornoAux[1]=fnConversionEntero(vRetornoAux[0]);}
					if(pCdValidacion2==2L) {vRetornoAux[1]=fnReemplazarCaracteres(vRetornoAux[0],pReemplazos);}
					if(pCdValidacion2==3L) {vRetornoAux[1]=fnRetornarPrimerCaracter(vRetornoAux[0]);}
					if(pCdValidacion2==4L) {vRetornoAux[1]=fnAcomodarDocumento(vRetornoAux[0]);}
					vRetorno=vRetornoAux[1];
				}else {
					vRetorno=vRetornoAux[0];
				}
			}else {
				vRetorno=pValor;
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return vRetorno;
	}
	public CoreGestionRemesa fnValidarNumeroTelefonico(CoreGestionRemesa pObjeto , String pValor,String pExpresionesRegulares) {
		if(pValor.length()>4) {
			 if(
			    		pValor.substring(0, 3).contentEquals("426")||
			    		pValor.substring(0, 3).contentEquals("416")||
			    		pValor.substring(0, 3).contentEquals("414")||
			    		pValor.substring(0, 3).contentEquals("424")||
			    		pValor.substring(0, 3).contentEquals("412")) {
			    	pObjeto.setNutelefono(pValor);
			    	pObjeto.setNutelefonohab("");
			    }
		}
	   
	    return pObjeto;
	}
	public String fnValidarCorreo(String pValor) {
		String pRetorno="";
		String pDireccion="";
		String pDominio="";
		try {
			if(pValor.length()>0) {
				String [] vArrayValoresCorreo=pValor.replace("@@","@").toUpperCase().split("@");
				if(vArrayValoresCorreo.length>1) {
					pDireccion=vArrayValoresCorreo[0]
							.replace("|", "")
							.replace("\\", "")
							.replace("/", "");
					
					pDominio=vArrayValoresCorreo[1]
							.replace("|", "")
							.replace("_", "")
							.replace("-", "")
							.replace("\\", "")
							.replace("/", "")
							.replace("HOTMAILCOM", "HOTMAIL.COM")
							.replace("GMAILCOM", "GMAIL.COM")
							.replace("OUTLOOKCOM", "OUTLOOK.COM")
							.replace("YAHOOCOM", "YAHOO.COM")
							;
					
					String vUltimoCaracter=pDominio.substring(pDominio.length()-1);
					if(vUltimoCaracter.equalsIgnoreCase(".") || vUltimoCaracter.equalsIgnoreCase("\\.")) {
						String vVAlorSinElUltimoCaracter=pDominio.substring(0,pDominio.length()-1);
						pDominio=vVAlorSinElUltimoCaracter;
					}
					String []vArrayDominios=pDominio.split("\\.");
					if(vArrayDominios.length>1) {
						if(vArrayDominios[0].isEmpty() ||vArrayDominios[0].length()==0 ) {
							
						}else {
							List<CoreExpresionCorreoPojo> vListaCoreExpresionCorreoPojo=
							coreExpresionCorreoRepo.fnBuscarExpresion(vArrayDominios[0]);
							if(vListaCoreExpresionCorreoPojo.size()>0) {
								pRetorno=pDireccion+"@"+vListaCoreExpresionCorreoPojo.get(0).getTxmodificacion();
							}else {
								pRetorno=pDireccion+"@"+pDominio;
							}
						}
						
					}if(vArrayDominios.length<=1) {
						List<CoreExpresionCorreoPojo> vListaCoreExpresionCorreoPojo=
						coreExpresionCorreoRepo.fnBuscarExpresion(vArrayDominios[0]);
						if(vListaCoreExpresionCorreoPojo.size()>0) {
							pRetorno=pDireccion+"@"+vListaCoreExpresionCorreoPojo.get(0).getTxmodificacion();
						}else {
							if(vArrayDominios.length<=1) {
								pRetorno=pDireccion+"@"+pDominio+".com";
							}
						}
						
					}
				}else {
					pRetorno="";
				}
				
			}else {
				pRetorno="";
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		return pRetorno;
	}
	public int fnValidaAreaTelefonica(String pValor,String pAreasTelefonicas) {
		int vRetorno=0;
		if(pValor.length()>0) {
			String [] vAreasTelefonicas=pAreasTelefonicas.split("\\|");
			for(int indice=0;indice<vAreasTelefonicas.length;indice++) {
				if(vAreasTelefonicas[indice].equalsIgnoreCase(pValor)) {
					vRetorno+=1;
				}
			}
		}
		return vRetorno;
	}
	public CoreGestionRemesa fnValidarNombreArchivo100x100(CoreGestionRemesa pObjeto, String pValor,String pExpresionRegular,String pArrayExpresiones) {
		if(pValor.length()>0) {
			String pNombreMayuscula=pValor.split("-")[0].toUpperCase().trim();
			String pNombreSinCaracteresEspeciales=pNombreMayuscula.replace("(","").replace(")", "").replace("#", "").replace(",", "").replace("..","").replace("<", "")
					.replace(">", "").replace(";", "").replace(":", "").replace("\"", "").replace("'", "").replace("[", "").replace("]", "")
					.replace("&","").replace("%", "");
			Pattern vPatron = Pattern.compile(" "+pExpresionRegular+" ", Pattern.CASE_INSENSITIVE);
			Matcher vValidadorExpresion = vPatron.matcher(pNombreSinCaracteresEspeciales);
			boolean matchFound = vValidadorExpresion.find();
			if(matchFound) {
				
			}else {
				String [] vArrayNombre=pNombreSinCaracteresEspeciales.split("-")[0].split(" ");
				if(vArrayNombre.length>=4) {
					
				}else {
					if(vArrayNombre.length==2) {
						pObjeto.setNmnombre1(vArrayNombre[0]);
						pObjeto.setNmapellido1(vArrayNombre[1]);	
					}
					if(vArrayNombre.length==3) {
						pObjeto.setNmnombre1(vArrayNombre[0]);
						pObjeto.setNmnombre2(vArrayNombre[1]);
						pObjeto.setNmapellido1(vArrayNombre[2]);
					}
				}
			}
		
		}
		return pObjeto;
	}
	public String fnRetornarPrimerCaracter(String pValor) {
		String vRetorno="";
		if(pValor.length()>0) {
			vRetorno=pValor.substring(0, 1);
		}
		return vRetorno;
	}
	public String fnConversionEntero(String pValor) {
		String vRetorno="";
		if(pValor.length()>0) {
			if(pValor.substring(0, 1).equals("0")) {
				vRetorno=pValor.substring(1, pValor.length());
			}
		}
		return vRetorno;
	}
	public String fnReemplazarCaracteres(String pValor,String pReemplazos) {
		String vRetorno="";
		if(pValor.length()>0) {
			String [] vReemplazos=new String[pReemplazos.split("\\|").length];
			
			vReemplazos=pReemplazos.split("\\|");
			for(int indice=0;indice<vReemplazos.length;indice++) {
				if(indice<1) {
					vRetorno=pValor.replace(vReemplazos[indice], "");
					vReemplazos[indice]=vRetorno;
				}else {
					vRetorno=vReemplazos[indice-1].replace(vReemplazos[indice], "");
					vReemplazos[indice]=vRetorno;
				}
			}
			vRetorno=vReemplazos[pReemplazos.split("\\|").length-1];
		}
		return vRetorno;
	}
	public String fnReemplazarCaracteresMultiple(String pValor,String pReemplazos,String pReemplazo) {
		String vRetorno="";
		if(pValor.length()>0) {
			String [] vReemplazos=new String[pReemplazos.split("\\|").length];
			
			vReemplazos=pReemplazos.split("\\|");
			for(int indice=0;indice<vReemplazos.length;indice++) {
				if(indice<1) {
					vRetorno=pValor.replace(vReemplazos[indice], pReemplazo);
					vReemplazos[indice]=vRetorno;
				}else {
					vRetorno=vReemplazos[indice-1].replace(vReemplazos[indice], pReemplazo);
					vReemplazos[indice]=vRetorno;
				}
			}
			vRetorno=vReemplazos[pReemplazos.split("\\|").length-1];
		}
		return vRetorno;
	}
	
	public String fnAcomodarDocumento(String pValor) {
		String vRetorno="";
		try {
			if(pValor.length()>0) {
				String [] vVAlores=pValor.split("-");
				vRetorno=vVAlores[1];
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return vRetorno;
	}
	
	public boolean fnValidaFormatoFecha(String vFeValor) {
        DateFormat vValidaFormato = new SimpleDateFormat("dd-MM-yyyy");
        vValidaFormato.setLenient(false);
        try {
        	vValidaFormato.parse(vFeValor);
        } catch (Exception e) {
            return false;
        }
        return true;
    }
	public boolean fnValidaNumero(String vNumero) {
        try {
        	Integer.parseInt(vNumero.replace(".0", ""));
        } catch (Exception e) {
            return false;
        }
        return true;
    }
	public List<String> fnRetornarValoresSQL(String pCampos, String pTabla,String pWhere) {
		List<Object[]> vRetornoQuery=null;
		List<String> vListaRetorno=new ArrayList<>();
		String vBusqueda="";
		try {
			vBusqueda="select "+pCampos+" FROM "+pTabla +" where "+pWhere;
			Query vQuery=entityManager.createNativeQuery(vBusqueda);
			vRetornoQuery=vQuery.getResultList();
			if(vRetornoQuery.size()>0) {
				for(Object[] v: vRetornoQuery) {
					 vListaRetorno.add(v[0]+"-"+v[1]);
				 }
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return vListaRetorno;
	}
	public Long fnValidarCorreoModificado(String vCorreoModificado) {
		Long vValidacion=0L;
		try {
			String vPatronString="^[a-zA-Z0-9_!#$%&amp;'*+/=?`{|}~^-]+(?:\\.[a-zA-Z0-9_!#$%&amp;'*+/=?`{|}~^-]+)*@[a-zA-Z0-9-]+(?:\\.[a-zA-Z0-9-]+)*$";
			Pattern  vPatron=Pattern.compile(vPatronString);
			Matcher vEmparejamiento=vPatron.matcher(vCorreoModificado);
			if(vEmparejamiento.matches()) {
				vValidacion=1L;
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return vValidacion;
	}
	public Long fnValidarDocumentoSinLetras(String vCorreoModificado) {
		Long vValidacion=0L;
		try {
			String vPatronString="^\\d+$";
			Pattern  vPatron=Pattern.compile(vPatronString);
			Matcher vEmparejamiento=vPatron.matcher(vCorreoModificado);
			if(vEmparejamiento.matches()) {
				vValidacion=1L;
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return vValidacion;
	}
	
	
}
