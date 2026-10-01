package Recursion;

public class Recursion {
public static void printArray(int[] array) {
	for(int i=0;i<array.length;i++) {
		System.out.println(array[i]);
	}
}
public static float averageOfArray(int[] array) {
	float sum=0;
	for(int i=0;i<array.length;i++) {
		sum=sum+array[i];
	}
float result = sum / array.length;
return result;
}
	public static void main(String[] args) {
		int size=5;
		int[] list=new int[10];
		int[] secondList= {4,6,3,6,3,6,2,12};
		float result=averageOfArray(secondList);
		String demo="abv";
		System.out.println(list);

	}

}
