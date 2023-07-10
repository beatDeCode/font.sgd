package ve.org.queue.gestion.data.core;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.autoconfigure.domain.EntityScan;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.data.jpa.repository.config.EnableJpaRepositories;

@SpringBootApplication
@ComponentScan(basePackages = { "ve.org.queue.gestion.data.services" })
@EnableJpaRepositories(basePackages = {"ve.org.queue.gestion.data.repos"})
@EntityScan(basePackages = {"ve.org.queue.gestion.data.pojos"})
public class CoreApplication {

	public static void main(String[] args) {
		SpringApplication.run(CoreApplication.class, args);
	}

}
