package Emil.SpringBootApplicationForStudents.response;

import java.util.ArrayList;
import java.util.List;

public class StudentResponse {
	
	private Long id;
	private String name;
	private List<Long> courses = new ArrayList<>();
	private List<Long> grades = new ArrayList<>();
	public Long getId() {
		return id;
	}
	public void setId(Long id) {
		this.id = id;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public List<Long> getCourses() {
		return courses;
	}
	public void setCourses(List<Long> toDoLists) {
		this.courses = courses;
	}
	public List<Long> getGrades() {
		return grades;
	}
	public void setGrades(List<Long> grades) {
		this.grades = grades;
	}
	
}
