package student.examples;

public class Student {
	private String name;
	private int age;
	private String fn;
	private String egn;
	private int year;
	public String getEgn() {
		return egn;
	}
	public void setEgn(String egn) {
	    if(egn.length()==10) {
	        int n1=Integer.parseInt(egn.substring(0,1));
	        int n2=Integer.parseInt(egn.substring(1,2));
	        int n3=Integer.parseInt(egn.substring(2,3));
	        int n4=Integer.parseInt(egn.substring(3,4));
	        int n5=Integer.parseInt(egn.substring(4,5));
	        int n6=Integer.parseInt(egn.substring(5,6));
	        int n7=Integer.parseInt(egn.substring(6,7));
	        int n8=Integer.parseInt(egn.substring(7,8));
	        int n9=Integer.parseInt(egn.substring(8,9));
	        int kontrolNumber=Integer.parseInt(egn.substring(9));
	        
	        int sum=n1*2;
	        sum+=n2*4;
	        sum+=n3*8;
	        sum+=n4*5;
	        sum+=n5*10;
	        sum+=n6*9;
	        sum+=n7*7;
	        sum+=n8*3;
	        sum+=n9*6;
	        int finalNumber=sum %11;
	        if(finalNumber==10) 
	            finalNumber=0;
	        if(finalNumber==kontrolNumber) {
	            this.egn=egn;
	            return;
	        }
	    }
	    System.err.println("Грешно егн!");
	}
	
	public String printInfo() {//method
		return "Name " + name + " age " + age + " egn " + egn;
	}
	public void moveToNextGrade() {//method(The method can be void(can't return value)and can return value)
		year++;
		System.out.println(name + " is now a student " + year + " year ");
	}
	public Student(String name,String fn,int age) {//constructor(He has to be with the SAME name of the CLASS)
		this.name=name;
		this.fn=fn;
		this.age=age;
		this.year=1;
	}
}
