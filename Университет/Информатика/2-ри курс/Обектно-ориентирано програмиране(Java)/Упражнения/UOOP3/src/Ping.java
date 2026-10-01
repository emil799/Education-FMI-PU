
public class Ping extends Thread{
	
	public void run() {
		for(int i = 1; i<=10; i++) {
			System.out.println(i);
			try {
				sleep(1000);
			} catch (InterruptedException e) {
				e.printStackTrace();
			}
		}
	}
	public static void main(String[] args) {
		Ping thread = new Ping();
		thread.setPriority(MIN_PRIORITY);
		thread.start();
		
		System.out.println("Thread:" + thread.getPriority());
		}
		
		
	}
