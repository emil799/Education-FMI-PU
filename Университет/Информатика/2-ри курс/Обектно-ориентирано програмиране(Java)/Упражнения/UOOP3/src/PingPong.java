
public class PingPong extends Thread{
	private String word;
	private int time;
	
	public PingPong(String word, int time) {
		this.word=word;
		this.time=time;
	}
	
	public void run() {
		for(int i = 0 ;  i<=5 ; i++) {
			System.out.println(word);
			try {
				sleep(time);
			} catch (InterruptedException e) {
				e.printStackTrace();
			}
		}
	}
	
	public static void main(String[] args) {
		new PingPong("Ping", 100).start();
		new PingPong("\tPONG", 100).start();
	}

}
