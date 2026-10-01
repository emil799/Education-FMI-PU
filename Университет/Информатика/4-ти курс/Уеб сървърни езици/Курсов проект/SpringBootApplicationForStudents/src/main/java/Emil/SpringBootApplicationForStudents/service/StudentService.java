package Emil.SpringBootApplicationForStudents.service;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import Emil.SpringBootApplicationForStudents.request.StudentRequest;
import Emil.SpringBootApplicationForStudents.response.StudentResponse;
import Emil.SpringBootApplicationForStudents.model.Student;
import Emil.SpringBootApplicationForStudents.repository.StudentRepository;




@Service
public class StudentService {
	private final StudentRepository studentRepository;
	@Autowired
	public StudentService(StudentRepository studentRepository) {
		super();
		this.studentRepository = studentRepository;
	}
	
	public StudentResponse findPersonById(Long id) {
		Optional<Student> result = studentRepository.findById(id);
		if (result.isPresent()) {
			if (result.get().getActive()) {
				StudentResponse resp = new StudentResponse();
				resp.setId(result.get().getId());
				resp.setName(result.get().getName());
				List<Long> t = new ArrayList<>();
				result.get().getCourses().stream().forEach(r -> t.add(r.getId()));
				resp.setGrades(t);
				return resp;
			}
		}
		return null;
	}
	
	public StudentResponse createPerson(StudentRequest student) {
		Student p = new Student();
		p.setName(student.getName());
		p.setCourses(new ArrayList<>());
		p.setActive(true);
		p = studentRepository.save(p);
		StudentResponse resp = new StudentResponse();
		resp.setId(p.getId());
		resp.setName(p.getName());
		resp.setCourses(new ArrayList<>());
		return resp;
	}
	
	public StudentResponse updateStudent(StudentRequest student, Long id) {
		Student result = studentRepository.findById(id).orElse(null);
		if (result != null) {
			if (result.getActive()) {
				if (student.getName() != null) {
					result.setName(student.getName());
				}
				result = studentRepository.save(result);
				StudentResponse resp = new StudentResponse();
				resp.setId(result.getId());
				resp.setName(result.getName());
				List<Long> t = new ArrayList<>();
				result.getCourses().stream().forEach(r -> t.add(r.getId()));
				resp.setCourses(t);;
				return resp;
			}
		}
		return null;
	}
	
	public Boolean deleteStudent(Long id) {
		Student result = studentRepository.findById(id).orElse(null);
		if (result != null) {
			result.setActive(false);
			studentRepository.save(result);
			return true;
		}
		return false;
	}
	
}
