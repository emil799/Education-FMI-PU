package Emil.SpringBootApplicationForStudents.repository;

import org.springframework.data.repository.CrudRepository;
import Emil.SpringBootApplicationForStudents.model.Student;

public interface StudentRepository extends CrudRepository<Student, Long>{

}
