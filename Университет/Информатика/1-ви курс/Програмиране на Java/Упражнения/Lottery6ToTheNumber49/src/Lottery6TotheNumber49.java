import java.util.Arrays;

public class Lottery6TotheNumber49 {

	public static void main(String[] args) {
		    System.out.println("Your lottery numbers are:");

		    for(int i=1; i<6; i++){

		        int[]lotteryNumbers = new int[6];

		        for(int j = 0; j < lotteryNumbers.length; j++){
		            lotteryNumbers[j] = (int)(Math.random()*49 + 1);
		        }

		        Arrays.sort(lotteryNumbers);
		        System.out.println(Arrays.toString(lotteryNumbers));
		    }
		 }

	}


