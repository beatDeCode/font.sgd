package ve.org.others.services.Others;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.ComponentScan;

@SpringBootApplication
@ComponentScan(basePackages = {"ve.org.others.services.rest","ve.org.others.services.logica"})
public class OthersApplication {

	public static void main(String[] args) {
		SpringApplication.run(OthersApplication.class, args);
	}

}
