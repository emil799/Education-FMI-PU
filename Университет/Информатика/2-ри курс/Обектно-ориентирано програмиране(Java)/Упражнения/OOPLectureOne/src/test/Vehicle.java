package test;

public abstract class Vehicle {
	String model;
	
	public Vehicle(String s) {
		this.model = s;
	}
	
	public abstract void printInfo();
	
}
