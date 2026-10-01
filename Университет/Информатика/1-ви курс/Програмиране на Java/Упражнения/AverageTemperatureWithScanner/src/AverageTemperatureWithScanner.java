import java.util.Scanner;

public class AverageTemperatureWithScanner {

	public static void main(String[] args) {
		Scanner input=new Scanner(System.in);
		System.out.println("Моля въведете температура за a:");
		double a=input.nextDouble();
		System.out.println("Моля въведете температура за b:");
		double b=input.nextDouble();
		System.out.println("Моля въведете температура за c:");
		double c=input.nextDouble();
		System.out.println("Моля въведете температура за d:");
		double d=input.nextDouble();
		System.out.println((a+b+c+d)/4);
		
		

	}

}
