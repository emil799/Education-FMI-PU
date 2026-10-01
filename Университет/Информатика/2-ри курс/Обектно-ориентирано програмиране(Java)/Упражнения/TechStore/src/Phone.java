
public class Phone extends Product {
	private int brc;
	private int gpr;
	
	public Phone(String brand, int brc, int gpr, int price) {
		super(brand, price);
		this.brc = brc;
		this.gpr = gpr;
		
	}//end constructor
	
	public String toString() {
		String middle = this.brc + "broi kameri, " + this.gpr + "god.";
		return "Phone: " + getProductAsString(middle);
	}
	
	public int getBrc() {
		return brc;
	}

	public void setColor(int brc) {
		this.brc = brc;
	}
	
	public int getGpr() {
		return gpr;
	}

	public void setDcm(int gpr) {
		this.gpr = gpr;
	}

	

	
}
