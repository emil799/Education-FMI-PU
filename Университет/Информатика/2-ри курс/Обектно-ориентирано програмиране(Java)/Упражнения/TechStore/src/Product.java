import java.util.Comparator;
import java.util.PriorityQueue;
import java.util.Objects;

public abstract class Product implements Comparator<Product> {
	private String brand;
	private Integer price;
	
	public Product(String brand, int price) {
		super();
		this.brand = brand;
		this.price = price;
	}
	@Override
	public int compare(final Product o1, final Product o2) {
		Objects.requireNonNull(o1,"o1 must not be null");
		Objects.requireNonNull(o2,"o2 must not be null");
		return (int)(o2.getPrice() - o1.getPrice());
		
		
	}
	

	public String getProductAsString(String middle) {	
		return this.brand + ", " + middle + this.price + " lv";
	}
	public String getBrand() {
		return brand;
	}
	public void setBrand(String brand) {
		this.brand = brand;
	}
	public int getPrice() {
		return price;
	}
	public void setPrice(int price) {
		this.price = price;
	}
	
	
}//end Product
