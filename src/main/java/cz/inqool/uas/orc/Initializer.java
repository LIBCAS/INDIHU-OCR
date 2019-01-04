package cz.inqool.uas.orc;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.ComponentScan;

import java.io.IOException;

/**
 * Main application entry. Fires up Spring boot initialization.
 */
@SpringBootApplication
@ComponentScan(basePackages = "cz.inqool.uas")
public class Initializer {
    public static void main(String[] args) throws IOException {
        SpringApplication.run(Initializer.class, args);
    }
}
