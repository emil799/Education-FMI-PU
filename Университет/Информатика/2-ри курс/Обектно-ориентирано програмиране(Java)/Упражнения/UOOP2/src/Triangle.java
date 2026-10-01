
public class Triangle extends Shape {

	public Triangle(float str1, float str2) {
		super(str1, str2);
		
	}

	@Override
	public float area() {
		
		return (str1 * str2) / 2;
	}
	
	
}
