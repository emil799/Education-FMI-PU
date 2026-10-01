package Lesson2;

import java.util.Scanner;

public class SwitchExample {

	public static void main(String[] args) {
		Scanner input = new Scanner(System.in);
		System.out.println("Моля въведете месец: ");
		String month = input.nextLine();
		System.out.println("Моля въведете годината: ");
		int year = input.nextInt();
		switch(month) {//31 30 28,29
		case "jan": case "mar": case "may": case "jul":
		case "aug": case "oct": case "dec":
			System.out.println("31");
			break;
		case "apr":
		case "jun":
		case "sep":
		case "nov":
			System.out.println("30");
		case "feb":
			if((year % 4 == 0) && (year % 100 != 0) || (year % 400 == 0)) {
				System.out.println("29");
			}
			else {
				System.out.println("28");
			}
			break;
			default:
				System.out.println("Error");
		}
	}

}
