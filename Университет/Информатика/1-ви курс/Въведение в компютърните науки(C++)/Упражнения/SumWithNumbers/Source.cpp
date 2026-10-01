/*Да се напише програма,която въвежда положително трицифрено число и извежда на отделни редове цифрите на стотиците,на десетиците и на единиците на числото.*/
#include <iostream>
using namespace std;
int main() {
	int a;
	cout << "a=";
	cin >> a;
	int s, d, e;
	s = a / 100;
	d = a / 10 % 10;
	e = a % 10;
	cout << "s=" << s << endl;
	cout << "d=" << d << endl;
	cout << "e=" << e << endl;
	return 0;
}