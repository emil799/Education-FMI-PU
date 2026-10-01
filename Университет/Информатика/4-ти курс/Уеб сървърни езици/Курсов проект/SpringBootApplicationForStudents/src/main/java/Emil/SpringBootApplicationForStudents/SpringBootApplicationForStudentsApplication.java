package Emil.SpringBootApplicationForStudents;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

import Emil.SpringBootApplicationForStudents.model.Student;
import Emil.SpringBootApplicationForStudents.repository.StudentRepository;



@SpringBootApplication
public class SpringBootApplicationForStudentsApplication {
	
	@Autowired
	private StudentRepository studentRepository;

	public static void main(String[] args) {
		SpringApplication.run(SpringBootApplicationForStudentsApplication.class, args);
	}

}
