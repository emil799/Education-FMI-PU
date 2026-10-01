package ExampleWithArrays;

public class ExampleWithArrays {

	public static void main(String[] args) {
		int[] numbers= {3,1,0,-5,-1,-4,11,-13};
		for(int i=0;i<numbers.length-1;i++) {
			for(int j=i + 1;j<numbers.length;j++) {
				if(numbers[i]>numbers[j]) {
					int temp=numbers[i];
					numbers[i]=numbers[j];
					numbers[j]=temp;
				}
			}
		}
		for(int element : numbers) {
			System.out.println(element + ",");
		}
		System.out.println();
		for(int i=0;i<numbers.length;i++) {
			System.out.println(numbers[i]+ " ");
		}

	}

}
