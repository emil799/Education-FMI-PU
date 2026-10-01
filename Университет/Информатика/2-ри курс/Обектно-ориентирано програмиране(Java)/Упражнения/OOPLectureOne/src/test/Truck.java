package test;

public class Truck extends Vehicle{

	int weight; // weight in tons
	
	public Truck(String s, int w) {
		super(s);
		this.weight = w;
	}

	@Override
	public void printInfo() {
		System.out.println("\n" + this.model + ", " + this.weight);
		
	}
	
	
	

	
	
	
	
}
