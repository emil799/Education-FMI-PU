package programming;

import java.util.Scanner;

public class Calculator {

	public static void main(String[] args) {
		Scanner in = new Scanner (System.in);
		System.out.println("Моля въведете две числа:");
		double a=in.nextDouble();
		double b=in.nextDouble();
		System.out.println("A*B= " + a*b);
		System.out.println("A/B="+ a/b);
		System.out.println("A+B="+ (a+b));
		System.out.println("A-B="+ (a-b));
	}

}
