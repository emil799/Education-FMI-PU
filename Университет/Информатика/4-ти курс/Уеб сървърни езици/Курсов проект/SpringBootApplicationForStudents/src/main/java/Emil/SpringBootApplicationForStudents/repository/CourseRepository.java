package Emil.SpringBootApplicationForStudents.repository;

import org.springframework.data.repository.CrudRepository;

import Emil.SpringBootApplicationForStudents.model.Course;

public interface CourseRepository extends CrudRepository<Course, Long>{

}
