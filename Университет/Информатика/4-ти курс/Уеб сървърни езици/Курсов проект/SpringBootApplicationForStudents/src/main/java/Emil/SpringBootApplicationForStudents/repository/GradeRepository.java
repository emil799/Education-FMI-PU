package Emil.SpringBootApplicationForStudents.repository;

import org.springframework.data.repository.CrudRepository;
import Emil.SpringBootApplicationForStudents.model.Grade;

public interface GradeRepository extends CrudRepository<Grade, Long>{

}
