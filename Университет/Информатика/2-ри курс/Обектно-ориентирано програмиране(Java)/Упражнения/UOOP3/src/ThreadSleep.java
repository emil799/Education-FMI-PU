
class ThreadA extends Thread{
	public void run() {
		for(int i = 1 ; i<= ThreadSleep.LIMIT; i++) {
			try {
				sleep(60);
				System.out.println("A:"+i);
				} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	}
}	
	class ThreadB extends Thread{
		public void run() {
			for(int i = -1; i>= -ThreadSleep.LIMIT; i--) {
				try {
				sleep(40);
				System.out.println("\tB:"+i);
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	}
}
			
	public class ThreadSleep {
		static final int LIMIT = 20;
			
	public static void main(String[] args) {
		new ThreadA().start();
		new ThreadB().start();
			
	}
			
}
