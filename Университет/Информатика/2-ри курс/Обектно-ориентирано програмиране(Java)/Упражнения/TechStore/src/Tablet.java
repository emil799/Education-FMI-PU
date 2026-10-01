
public class Tablet extends Product{
	private String color;
	private int dcm;
	
	public Tablet(String brand, String color, int dcm, int price) {
		super(brand, price);
		this.color = color;
		this.dcm = dcm;
		
	}//end constructor
	
	public String toString() {
		String middle = this.color + "cvqt, " + this.dcm + "cm";
		return "Tablet: " + getProductAsString(middle);
	}
	
	public String getColor() {
		return color;
	}

	public void setColor(String color) {
		this.color = color;
	}
	
	public int getDcm() {
		return dcm;
	}

	public void setDcm(int dcm) {
		this.dcm = dcm;
	}


}
