package Emil.SpringBootApplicationForStudents.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;


@RestController
@RequestMapping("/teachers")
public class TeacherController {

	@Autowired
    @GetMapping("/teachers")
	public String home() {
        return "Добре дошли в моето Spring Boot приложение!";
	
	}
}
