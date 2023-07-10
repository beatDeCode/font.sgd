package com.ve.gestiondata.mailcore.MailCore;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.autoconfigure.domain.EntityScan;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.data.jpa.repository.config.EnableJpaRepositories;


@ComponentScan(basePackages = "com.ve.gestiondata.mailcore.servicios")
@EntityScan(basePackages = "com.ve.gestiondata.mailcore.pojos")
@EnableJpaRepositories(basePackages = "com.ve.gestiondata.mailcore.repos")
@SpringBootApplication
public class MailCoreApplication {

	public static void main(String[] args) {
		SpringApplication.run(MailCoreApplication.class, args);
	}

}
