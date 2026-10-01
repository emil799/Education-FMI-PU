
public class Store {
	
	public static void orderInfo(Product item) {
		item.showName();
		item.showLoc();
		System.out.println(item.MARKA+ " "+item.PHONE);
		System.out.println(item.getPrice(50));
	}
	
	public static void main(String[] args) {
		Book java = new Book();
		Shoes boti = new Shoes();
		
		orderInfo(java);
		orderInfo(boti);
		
		
		
	}

}
