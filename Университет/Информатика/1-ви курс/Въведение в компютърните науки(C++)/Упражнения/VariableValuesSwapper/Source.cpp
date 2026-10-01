/*Да се напише програма,въвежда стойността на реалните променливи a и b,след което разменя и извежда стойностите им.*/
#include <iostream>
using namespace std;
int main() {
	double a, b;
	cout << "a=";
	cin >> a;
	cout << "b=";
	cin >> b;
	double c = a;
	a = b;
	b = c;
	cout << "a=" << a << endl;
	cout << "b=" << b << endl;
	return 0;
}