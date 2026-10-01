
public class Hanoi {
	static int br = 0;
	
	static void move(int n, char start, char help, char goal) {
		if(n==1) {
			System.out.println("Ot "+start+" na "+goal);
		}
		else {
			move(n-1, start, goal, help);
			System.out.println("Ot "+start+" na "+goal);
			move(n-1, help, start, goal);
		}
		br++;
	}
	
	public static void main(String[] args) {
		
		move(3,'A','B','C');
		System.out.println(br);
	}

}
