
public class Person {
    String name;
	int age;
	
	public Person(String name, int age) {
		this.name = name;
		this.age  = age;
	}
	public Person(int age, String name) {
		this.name = name;
		this.age  = age;
	}
	void printInfo() {
		System.out.print(name + " " + age + " ");
	}
}
