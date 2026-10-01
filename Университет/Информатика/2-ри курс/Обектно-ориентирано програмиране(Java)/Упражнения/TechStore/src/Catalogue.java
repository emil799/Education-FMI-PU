import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;
import java.util.PriorityQueue;
import java.util.stream.Collectors;

public class Catalogue {

private ArrayList<Product> list = new ArrayList<>();

	public void sortByPriceComparator() {
		Comparator<Product> byPrice = (Product o1,Product o2) -> o2.getPrice() - o1.getPrice();
		list.sort(byPrice);
		
	}
	
	
	
	public void readProductsFromFile(String pathToFile) {
		ArrayList<String> fromFile = readFileByRow(pathToFile);
		for(String s : fromFile) {
			list.add(convertStringToProduct(s));
		}

		
	}//end method
public void writeCatalogueToFile(String pathToFile) {
		
		try(BufferedWriter bw = Files.newBufferedWriter(Paths.get(pathToFile))){
			
			for(Product product : list) {
				bw.write(product.toString());
				bw.newLine();
			}
			
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}//method
public void printCatalogue() {
	for(Product product : list) {
		System.out.println(product);
	}
}

private ArrayList<String> readFileByRow(String pathToFile){
	
	ArrayList<String> fromFile = new ArrayList<>();
	
	try(BufferedReader br = Files.newBufferedReader(Paths.get(pathToFile))){
		
		fromFile = (ArrayList<String>) br.lines().collect(Collectors.toList());
		
	} catch (IOException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
	}
	
	return fromFile;
}//end method
private Product convertStringToProduct(String productString) {
	
	String[] productList = productString.split(", ");
	String brand, color;
	int price, dcm,brc,gpr;
	
	String[] beginning = productList[0].split(" ");
	String keyWord = beginning[0];
	brand = productList[1];
	
	
	
	String priceAsString = productList[productList.length-1].replace(" lv", "");
	price = Integer.parseInt(priceAsString);
	
	
	switch(keyWord) {
	
	case "Tablet: " : 	color = String.valueOf(productList[2].replace("cvqt",""));
						  dcm = Integer.parseInt(productList[3].replace("cm", ""));
						  return new Tablet(brand, color, dcm, price);
						  
	case "Phone: " :	brc = Integer.parseInt(productList[2].replace("broi kameri", ""));
						gpr = Integer.parseInt(productList[3].replace("god.", ""));
						return new Phone(brand, brc, gpr, price);
						
	
	}//end switch
	return null;
}//end method

	
}
