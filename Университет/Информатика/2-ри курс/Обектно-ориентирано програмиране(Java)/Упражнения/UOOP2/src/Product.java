
public interface Product extends Country{
	static final String MARKA = "My Corp.";
	String PHONE = "555-666-777";
	public abstract String getPrice(int br);
	public void showName();
	
}
