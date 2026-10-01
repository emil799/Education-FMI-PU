package Emil.SpringBootApplicationForStudents.repository;

import org.springframework.data.repository.CrudRepository;
import Emil.SpringBootApplicationForStudents.model.Teacher;

public interface TeacherRepository extends CrudRepository<Teacher, Long>{

}
