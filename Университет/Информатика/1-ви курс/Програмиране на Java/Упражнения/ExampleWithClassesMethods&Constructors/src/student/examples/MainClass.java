package student.examples;

public class MainClass {

	public static void main(String[] args) {
		Student s1=new Student("Ivan","0000000000",72);
		Student s2=new Student("Emil","0000000000",20);
		s2.moveToNextGrade();
		s1.setEgn("0000000000");
		System.out.println(s1.printInfo());
		System.out.println(s2.printInfo());


	}

}
