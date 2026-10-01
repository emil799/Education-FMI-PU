
public class PowerKN {
	
	static double power(int k, int n) {
		if(n == 0) {
			return 1;
		}
		else {
			double t = power(k, n/2);
			if(n%2 == 0) {
				return t*t;
			}
			else {
				 return t*t*k;
			}
		}
	}
	
	public static void main(String[] args) {
		int k = 100, n=100;
		
		System.out.println(k+"**"+n+"="+power(k,n));
	}

}
