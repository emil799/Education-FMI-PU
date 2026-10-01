
public class RunPingPong implements Runnable{
	String word;
	int time;
	
	public RunPingPong(String word, int time) {
		this.word = word;
		this.time = time;
	}
	@Override
	public void run() {
		for(int i = 0 ; i<=5 ; i++) {
		System.out.println(word);
		try {
			Thread.sleep(time);
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
	}
	}
public static void main(String[] args) {
	RunPingPong ping = new RunPingPong("Ping", 1000);
	RunPingPong pong = new RunPingPong("\tPONG", 1000);
	
	new Thread(ping).start();
	new Thread(pong).start();
	}

}
