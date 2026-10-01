
public class Book implements Product {

	@Override
	public String getPrice(int br) {
		if(br<100) {
			return "Промоция";
		}
		else {
			return "Няма промоция";
		}
		
	}

	@Override
	public void showName() {
		System.out.println("Книга");
		
	}

	@Override
	public void showLoc() {
		System.out.println("Съединени щати");
		
	}

}
