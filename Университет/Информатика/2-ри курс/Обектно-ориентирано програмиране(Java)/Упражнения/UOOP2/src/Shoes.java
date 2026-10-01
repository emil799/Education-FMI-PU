
public class Shoes implements Product{
	@Override
	public String getPrice(int br) {
		if(br<5) {
			return "Промоция";
		}
		else {
			return "Няма промоция";
		}
		
	}

	@Override
	public void showName() {
		System.out.println("Обувки");
		
	}

	
}
