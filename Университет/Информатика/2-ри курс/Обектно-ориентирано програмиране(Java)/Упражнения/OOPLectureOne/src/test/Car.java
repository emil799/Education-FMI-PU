package test;

public class Car extends Vehicle{ // Object
	
	
	float price;
	String color;
	
	public Car(String m, float p, String c) {
		super(m);
		this.price = p;
		this.color = c;
	}
	
	public String toString() {
		return this.model + ", " + this.price + ", " + this.color;
	}
	public void printInfo() {
	System.out.print("\n" + this.model + ", " + this.price+", " + this.color);
	}
}
