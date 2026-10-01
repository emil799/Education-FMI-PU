
public class Student extends Person {
	String spec;
	float uspeh;
	
	Student(String name, int age, String spec, float uspeh){
		super(name, age);
		this.spec = spec;
		this.uspeh = uspeh;
		
	}
	
	float getUspeh() {
		return uspeh;
	}
	
	public void printInfo() {
		super.printInfo();
		System.out.println(spec + " " + uspeh);
	}
}
