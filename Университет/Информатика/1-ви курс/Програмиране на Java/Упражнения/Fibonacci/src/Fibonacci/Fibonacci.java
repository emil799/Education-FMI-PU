package Fibonacci;

import java.util.Scanner;

public class Fibonacci {

	public static void main(String[] args) {
		Scanner input=new Scanner(System.in);
		int num1=0;
		int num2=0;
		System.out.println("До кое число искаш да въвеждаш?");
		int count=input.nextInt();
		System.out.print("0, 1");
		
		for(int i = 1; i <= count - 2; i++) {
			int temp = num1 + num2;
			
			System.out.print("," + temp);
			
			num1 = num2;
			num2 = temp;
			}

	

	}
}