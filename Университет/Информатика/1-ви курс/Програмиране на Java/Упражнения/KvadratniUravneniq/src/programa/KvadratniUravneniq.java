package programa;

import java.util.Scanner;

public class KvadratniUravneniq {

	public static void main(String[] args) {
		Scanner input = new Scanner(System.in);  
		System.out.println("Моля въведете стойности за a,b,c: ");
		double a=input.nextDouble();
		double b=input.nextDouble();
		double c=input.nextDouble();
		double d=b*b - 4*a*c;
		if(d<0) {
			System.out.println("Няма реални корени!");
			}
		else if(d>0) {
			double x1=(-b + Math.sqrt(d)) / (2*a);
			double x2=(-b - Math.sqrt(d)) / (2*a);
			System.out.println("X1=" + x1 + "X2=" + x2);
		}else {
			double x1=-b/(2*a);
			System.out.println("x=" + x1);
		}
		}
	}


