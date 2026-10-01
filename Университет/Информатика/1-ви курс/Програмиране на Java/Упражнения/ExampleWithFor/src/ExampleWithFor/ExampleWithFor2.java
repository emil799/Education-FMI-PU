package ExampleWithFor;

public class ExampleWithFor2 {

	public static void main(String[] args) {
		boolean isPrime=true;
		for(int i = 0; i <= 10000; i++) {
			isPrime=true;
			for(int j = 2; j < i / 2 ; j++) {
				if(i % j == 0) {
					isPrime=false;
					break;
				}
			}
			if(isPrime) {
				System.out.println(i);
			}
		}

	}

}
