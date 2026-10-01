package test;

public class SportCar extends Car {
	
	String race;
	
	public SportCar(String m, float p, String c, String r) {
		super(m, p, c);
		this.race = r;
	}
	
	public String toString() {
		return super.toString() + ", " + this.race;
	}
	public void printInfo() {
		super.printInfo();
		System.out.print(", " + this.race);
	}
}
