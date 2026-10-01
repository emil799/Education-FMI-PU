
public class FactN {
	// n!=1*2*3*...N
	// 5!=1*2*3*4*5
	static int factN(int n) {
		if(n == 1) {
			return 1;
		}
		else {
			return n*factN(n-1);
		}
	}
	
	public static void main(String[] args) {
		// 5*4*3*2*1
		
		int n = 5;
		System.out.println(n+"!="+factN(n));
	}

}
