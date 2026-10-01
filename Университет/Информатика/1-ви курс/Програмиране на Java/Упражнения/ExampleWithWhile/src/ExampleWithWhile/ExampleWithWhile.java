package ExampleWithWhile;

import java.util.Scanner;

public class ExampleWithWhile {

	public static void main(String[] args) {
		Scanner input=new Scanner(System.in);
		
		int i;
		do {
			System.out.println("Моля въведете число от 5 до 100: ");
			i=input.nextInt();
		}
		while(i<5 || i>100);
		System.out.println("Браво!");

	}

}
