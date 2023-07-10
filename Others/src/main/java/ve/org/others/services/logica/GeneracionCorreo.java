package ve.org.others.services.logica;

import java.io.File;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.core.io.FileSystemResource;
import org.springframework.mail.javamail.JavaMailSenderImpl;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.stereotype.Service;

import jakarta.mail.internet.MimeMessage;
import ve.org.others.services.rest.SolicitudCorreo;

@Service
public class GeneracionCorreo {
	
	@Value("${core.correo.host}")
	private String aHostCorreo;
	
	@Value("${core.correo.port}")
	private int aPortCorreo;
	
	@Value("${core.correo.direccion}")
	private String aDireccionCorreo;
	
	@Value("${core.directorio.compilados}")
	private String aPathCompilados;
	
	public void fnEnviarCorreo(SolicitudCorreo pSolicitud){
		//System.out.println(pSolicitud.getTxAsuntoCorreo()+" "+pSolicitud.getTxDireccionCorreo());
    	JavaMailSenderImpl mailSender = new JavaMailSenderImpl();
    	mailSender.setPort(aPortCorreo);
    	mailSender.setHost(aHostCorreo);
		MimeMessage message = mailSender.createMimeMessage();
	    MimeMessageHelper helper;
		try {
			helper = new MimeMessageHelper(message, true);
			helper.setFrom(aDireccionCorreo);
		    helper.setCc(pSolicitud.getTxDireccionCorreo());
		    helper.setSubject(pSolicitud.getTxAsuntoCorreo());
			helper.setText(fnEnvioContrasenia(pSolicitud.getTxMensajeCuerpoCorreo()),true);
			FileSystemResource vLogoWs = new FileSystemResource(new File(aPathCompilados+"fondo1.png"));
			FileSystemResource vDivision = new FileSystemResource(new File(aPathCompilados+"division1.png"));
	    	helper.addInline("logo",vLogoWs);
	    	helper.addInline("division",vDivision);
	    	
		    mailSender.send(message);
			
		} catch (Exception e) {
			e.printStackTrace();
		}
    }
	public String fnEnvioContrasenia(String pAsuntoMensaje) {
		return "<html>\r\n"
				+ "  <head>\r\n"
				+ "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n"
				+ "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n"
				+ "    <title>Simple Transactional Email</title>\r\n"
				+ "    <style>\r\n"
				+ "@media only screen and (max-width: 620px) {\r\n"
				+ "  table.body h1 {\r\n"
				+ "    font-size: 28px !important;\r\n"
				+ "    margin-bottom: 10px !important;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  table.body p,\r\n"
				+ "table.body ul,\r\n"
				+ "table.body ol,\r\n"
				+ "table.body td,\r\n"
				+ "table.body span,\r\n"
				+ "table.body a {\r\n"
				+ "    font-size: 16px !important;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  table.body .wrapper,\r\n"
				+ "table.body .article {\r\n"
				+ "    padding: 10px !important;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  table.body .content {\r\n"
				+ "    padding: 0 !important;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  table.body .container {\r\n"
				+ "    padding: 0 !important;\r\n"
				+ "    width: 100% !important;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  table.body .main {\r\n"
				+ "    border-left-width: 0 !important;\r\n"
				+ "    border-radius: 0 !important;\r\n"
				+ "    border-right-width: 0 !important;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  table.body .btn table {\r\n"
				+ "    width: 100% !important;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  table.body .btn a {\r\n"
				+ "    width: 100% !important;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  table.body .img-responsive {\r\n"
				+ "    height: auto !important;\r\n"
				+ "    max-width: 100% !important;\r\n"
				+ "    width: auto !important;\r\n"
				+ "  }\r\n"
				+ "}\r\n"
				+ "@media all {\r\n"
				+ "  .ExternalClass {\r\n"
				+ "    width: 100%;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  .ExternalClass,\r\n"
				+ ".ExternalClass p,\r\n"
				+ ".ExternalClass span,\r\n"
				+ ".ExternalClass font,\r\n"
				+ ".ExternalClass td,\r\n"
				+ ".ExternalClass div {\r\n"
				+ "    line-height: 100%;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  .apple-link a {\r\n"
				+ "    color: inherit !important;\r\n"
				+ "    font-family: inherit !important;\r\n"
				+ "    font-size: inherit !important;\r\n"
				+ "    font-weight: inherit !important;\r\n"
				+ "    line-height: inherit !important;\r\n"
				+ "    text-decoration: none !important;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  #MessageViewBody a {\r\n"
				+ "    color: inherit;\r\n"
				+ "    text-decoration: none;\r\n"
				+ "    font-size: inherit;\r\n"
				+ "    font-family: inherit;\r\n"
				+ "    font-weight: inherit;\r\n"
				+ "    line-height: inherit;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  .btn-primary table td:hover {\r\n"
				+ "    background-color: #34495e !important;\r\n"
				+ "  }\r\n"
				+ "\r\n"
				+ "  .btn-primary a:hover {\r\n"
				+ "    background-color: #34495e !important;\r\n"
				+ "    border-color: #34495e !important;\r\n"
				+ "  }\r\n"
				+ "}\r\n"
				+ "</style>\r\n"
				+ "  </head>\r\n"
				+ "  <body style=\"background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">\r\n"
				+ "\r\n"
				+ "    <span class=\"preheader\" style=\"color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;\">This is preheader text. Some clients will show this text as a preview.</span>\r\n"
				+ "    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;\" width=\"100%\" bgcolor=\"#f6f6f6\">\r\n"
				+ "      <tr>\r\n"
				+ "        <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\" valign=\"top\">&nbsp;</td>\r\n"
				+ "        <td class=\"container\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 740px; padding: 10px; width: 740px; margin: 0 auto;\" width=\"580\" valign=\"top\">\r\n"
				+ "          <div class=\"content\" style=\"box-sizing: border-box; display: block; margin: 0 auto; max-width: 740px; padding: 10px;\">\r\n"
				+ "            <!-- START CENTERED WHITE CONTAINER -->\r\n"
				+ "            <table role=\"presentation\" class=\"main\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;\" width=\"100%\">\r\n"
				+ "\r\n"
				+ "              <!-- START MAIN CONTENT AREA -->\r\n"
				+ "              <tr>\r\n"
				+ "                <td class=\"wrapper\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;\" valign=\"top\">\r\n"
				+ "                  <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;\" width=\"100%\">\r\n"
				+ "                    <tr>\r\n"
				+ "                      <td style=\"font-family: sans-serif; font-size: 14px;padding: 10px; vertical-align: top;\" valign=\"top\">\r\n <br>"
				+ "                        <img src=\"cid:logo\" height=\"120\" width=\"700\" style=\"padding: 10px;border-radius: 10px;\">\r\n"
				+ "                        <img src=\"cid:division\" height=\"15\" width=\"700\" style=\"padding: 10px;\">\r\n"
				+ "                        <p>"+pAsuntoMensaje
				+ "                        </p>\r\n"
				+ "                        <img src=\"cid:division\" height=\"15\" width=\"700\" style=\"padding: 10px;\">\r\n"
				+ "                        \r\n"
				+ "                      </td>\r\n"
				+ "                    </tr>\r\n"
				+ "                  </table>\r\n"
				+ "                </td>\r\n"
				+ "              </tr>\r\n"
				+ "            <!-- END MAIN CONTENT AREA -->\r\n"
				+ "            </table>\r\n"
				+ "            <!-- END CENTERED WHITE CONTAINER -->\r\n"
				+ "\r\n"
				+ "            <!-- START FOOTER -->\r\n"
				+ "            <div class=\"footer\" style=\"clear: both; margin-top: 10px; text-align: center; width: 100%;\">\r\n"
				+ "              <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;\" width=\"100%\">\r\n"
				+ "                <tr>\r\n"
				+ "                  <td class=\"content-block\" style=\"font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;\" valign=\"top\" align=\"center\">\r\n"
				+ "                    <span class=\"apple-link\" style=\"color: #999999; font-size: 12px; text-align: center;\">Company Inc, 3 Abbey Road, San Francisco CA 94102</span>\r\n"
				+ "                    <br> Don't like these emails? <a href=\"http://i.imgur.com/CScmqnj.gif\" style=\"text-decoration: underline; color: #999999; font-size: 12px; text-align: center;\">Unsubscribe</a>.\r\n"
				+ "                  </td>\r\n"
				+ "                </tr>\r\n"
				+ "                <tr>\r\n"
				+ "                  <td class=\"content-block powered-by\" style=\"font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;\" valign=\"top\" align=\"center\">\r\n"
				+ "                    Powered by <a href=\"http://htmlemail.io\" style=\"color: #999999; font-size: 12px; text-align: center; text-decoration: none;\">HTMLemail</a>.\r\n"
				+ "                  </td>\r\n"
				+ "                </tr>\r\n"
				+ "              </table>\r\n"
				+ "            </div>\r\n"
				+ "            <!-- END FOOTER -->\r\n"
				+ "\r\n"
				+ "          </div>\r\n"
				+ "        </td>\r\n"
				+ "        <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\" valign=\"top\">&nbsp;</td>\r\n"
				+ "      </tr>\r\n"
				+ "    </table>\r\n"
				+ "  </body>\r\n"
				+ "</html>";
	}
}
