package Emil.SpringBootApplicationForStudents.service;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import Emil.SpringBootApplicationForStudents.model.Teacher;
import Emil.SpringBootApplicationForStudents.repository.TeacherRepository;
import Emil.SpringBootApplicationForStudents.request.TeacherRequest;
import Emil.SpringBootApplicationForStudents.response.TeacherResponse;

@Service
public class TeacherService {
	
	private final TeacherRepository teacherRepository;
	@Autowired
	public TeacherService(TeacherRepository teacherRepository) {
		super();
		this.teacherRepository = teacherRepository;
	}
	
	public TeacherResponse findPersonById(Long id) {
		Optional<Teacher> result = teacherRepository.findById(id);
		if (result.isPresent()) {
			if (result.get().getActive()) {
				TeacherResponse resp = new TeacherResponse();
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
	
	public TeacherResponse createPerson(TeacherRequest teacher) {
		Teacher p = new Teacher();
		p.setName(teacher.getName());
		p.setCourses(new ArrayList<>());
		p.setActive(true);
		p = teacherRepository.save(p);
		TeacherResponse resp = new TeacherResponse();
		resp.setId(p.getId());
		resp.setName(p.getName());
		resp.setCourses(new ArrayList<>());
		return resp;
	}
	
	public TeacherResponse updateTeacher(TeacherRequest teacher, Long id) {
		Teacher result = teacherRepository.findById(id).orElse(null);
		if (result != null) {
			if (result.getActive()) {
				if (teacher.getName() != null) {
					result.setName(teacher.getName());
				}
				result = teacherRepository.save(result);
				TeacherResponse resp = new TeacherResponse();
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
	
	public Boolean deleteTeacher(Long id) {
		Teacher result = teacherRepository.findById(id).orElse(null);
		if (result != null) {
			result.setActive(false);
			teacherRepository.save(result);
			return true;
		}
		return false;
	}
	
}
