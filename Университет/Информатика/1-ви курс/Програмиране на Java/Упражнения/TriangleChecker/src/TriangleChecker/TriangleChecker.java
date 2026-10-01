package TriangleChecker;

import java.util.Scanner;

public class TriangleChecker {

	public static void main(String[] args) {
		Scanner input=new Scanner(System.in);
		System.out.println("Моля въведете стойности за a,b,c: ");
		double a=input.nextDouble();
		double b=input.nextDouble();
		double c=input.nextDouble();
		if(a + b <= c || a + c <= b || b + c <= a) {
			System.out.println("Съществува такъв триъгълник!");
		}
		else {
			System.out.println("Не съществува такъв триъгълник!");
		}
		if(a==b && b==c) {
			System.out.println("Това е равностранен триъгълник!");
		}
		else if(a==b || b==c || c==a) {
			System.out.println("Това е равнобедрен триъгълник!");
		}
		else {
			System.out.println("Това е разностранен триъгълник!");
		}

	}

}
