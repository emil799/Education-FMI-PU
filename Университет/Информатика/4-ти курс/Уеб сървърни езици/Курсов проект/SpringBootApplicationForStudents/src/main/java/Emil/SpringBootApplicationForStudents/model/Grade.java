package Emil.SpringBootApplicationForStudents.model;

import java.util.ArrayList;
import java.util.List;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.ManyToOne;

@Entity
public class Grade {
	
	@Column(name = "grade", nullable = false)
    private int value;

    @ManyToOne
    private Student student;
    private List<Student> students = new ArrayList<>();
    
    @ManyToOne
    private Course course;
    private List<Course> courses = new ArrayList<>();
    
	public int getValue() {
		return value;
	}

	public void setValue(int value) {
		this.value = value;
	}

	public Student getStudent() {
		return student;
	}

	public void setStudent(Student student) {
		this.student = student;
	}

	public Course getCourse() {
		return course;
	}

	public void setCourse(Course course) {
		this.course = course;
	}

    
}
