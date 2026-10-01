import java.util.ArrayList;
import java.util.Scanner;

import javax.swing.JOptionPane;

public class MainClass {

	public static void main(String[] args) {
		
		/*String name;
		int age;
		
		name = JOptionPane.showInputDialog("Име:");
		
		Scanner vhod = new Scanner(System.in);
		System.out.print("Години:");
		age=vhod.nextInt();*/
		
		Person az = new Person("Emil Medarov", 20);
		//Person ti = new Person(21, "Emiliq Hristova");
		Student s1 = new Student("Emil Medarov", 20, "Informatika", 4.09f);
		Student s2 = new Student("Todor Todorov", 30, "Informatika", 5);
		Student s3 = new Student("Georgi Georgiev", 33, "BIT", 6);
		//az.name = "Emil Medarov";
		//az.age = 20;
		//Person.age = 30;
		//Person.name = "zzz";
		
		
		//az.printInfo();
		//ti.name = "Emiliq Hristova";
		//ti.age = 20;
		
		//ti.printInfo();
		//s1.printInfo();
		//s2.printInfo();
		//s1 = az;
		/*az = s1;
		
		Object o = new Object();
		
		o = az;
		o = s1;
		o = new MainClass();
		o  = 10;
		o = 5.5;
		o = 5.8f;
		o = 'A';
		o = "Informatika";*/
		ArrayList<Student> arr = new ArrayList();
		
		/*arr.add(az);
		arr.add(s1);
		arr.add(10);
		arr.add(5.5f);
		arr.add(4.5);
		arr.add('A');
		arr.add("Informatika");
		arr.add(2,new MainClass());*/
		
		
		arr.add(s1);
		arr.add(s2);
		arr.add(s3);
		
		float maxUspeh = Float.MIN_VALUE;
		int st=0;
		
		
		/*for(Object o:arr) {
			System.out.println(o.getClass().getSimpleName());*/
		for(int i = 0 ; i<arr.size(); i++) {
			if(arr.get(i).getUspeh()>maxUspeh) {
				maxUspeh = arr.get(i).getUspeh();
				st=i;
			}
		}
		arr.get(st).printInfo();
		}
	}


