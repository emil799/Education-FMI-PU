import java.util.ArrayList;

public class MainClass {

	public static void main(String[] args) {
		Triangle t1 = new Triangle(3, 5);
		Triangle t2 = new Triangle(30, 5);
		Triangle t3 = new Triangle(3, 50);
		Rectangle r1 = new Rectangle(5, 6);
		Rectangle r2 = new Rectangle(50, 6);
		Rectangle r3 = new Rectangle(5, 60);
		
		
		//System.out.println("Area triangle:"+ t1.area());
		//System.out.println("Area rectangle:"+ r1.area());
		
		ArrayList<Shape> arr = new ArrayList<Shape>();
		
		arr.add(t1);
		arr.add(t2);
		arr.add(t3);
		
		arr.add(r1);
		arr.add(r2);
		arr.add(r3);
		
		float maxTriangle = Float.MIN_VALUE;
		float minRectangle = Float.MAX_VALUE;
		
		
		for(int i = 0 ; i<arr.size(); i++) {
			if(arr.get(i) instanceof Triangle) {
				if(arr.get(i).area()>maxTriangle) {
					maxTriangle = arr.get(i).area();
				}
				else;
			}
			else {
				if(arr.get(i).area()<minRectangle) {
					minRectangle = arr.get(i).area();
				}
				else;
			}

}
		System.out.println("Max area triangle:" + maxTriangle);
		System.out.println("Min area rectangle" + minRectangle);
		
		
}
}