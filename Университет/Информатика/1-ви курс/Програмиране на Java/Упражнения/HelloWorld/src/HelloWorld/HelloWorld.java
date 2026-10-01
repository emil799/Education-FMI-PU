package HelloWorld;
import java.util.Scanner;
public class HelloWorld {

	public static void main(String[] args) {
		Scanner keyboard=new Scanner(System.in);
		System.out.println("Моля въведете си името:");
		String name=keyboard.nextLine();
		System.out.println("Hello " + name + "!");

	}

}
