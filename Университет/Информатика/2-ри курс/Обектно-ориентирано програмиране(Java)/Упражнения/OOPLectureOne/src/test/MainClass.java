package test;

import java.util.ArrayList; // .jar -> Java Archive

public class MainClass {

	public static void main(String[] args) {
		Car car = new Car("Audi A4",20000.00f, "Blue");
		//System.out.println(car);  // car.toString() from Object Class
		// RTTI - Run Time Type Identification
		SportCar sportCar = new SportCar("McLaren", 100000.00f, "Grey", "F1"); // 3 contructors are running in sequence
		//System.out.println(sportCar); // sportCar.toString()
		
		/*Car[] list = new Car[4];
		list[0] = car;
		list[1] = sportCar;
		list[2] = new Car("BMW 320i", 22000, "Black");
		list[3] = new SportCar("Lotus", 90000, "Yellow", "F2");*/
		
		/*for(int i=0;i<list.length;i++) {
			list[i].printInfo();
		} //end for
		*/
	ArrayList<Vehicle> arrList = new ArrayList<>(); //Map, HashMap, List, Set, HashSet ... Collection, ResultSet
	System.out.println("The size of arrayList is:" + arrList.size());
	arrList.add(car); //add car at index 0 
	arrList.add(new Car("BMW 320i", 22000, "Black")); //add car at index 1
	System.out.println("The size of arrayList is:" + arrList.size());
	arrList.add(1, sportCar); //insert car at index 1 -> BMW goes at index 2
	arrList.add(new Truck("Volvo", 12));
	System.out.println("The size of arrayList is:" + arrList.size());
	
	for(int i=0; i<arrList.size(); i++) {
		arrList.get(i).printInfo();
	}
	arrList.remove(0);
	System.out.println("The size of arrayList is:" + arrList.size());
	
	
	} //end main ()

} //end MainClass
