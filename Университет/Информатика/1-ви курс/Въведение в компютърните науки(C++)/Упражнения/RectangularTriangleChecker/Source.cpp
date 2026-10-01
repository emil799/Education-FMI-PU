/*При въвеждане на размерите на 3 страни на триъгълник да се определи,дали триъгълникът е правоъгълен.*/
#include <iostream>
using namespace std;
int main() {
	double a, b, c;
	cout << "a=";
	cin >> a;
	cout << "b=";
	cin >> b;
	cout << "c=";
	cin >> c;
	if (a * a == (b * b + c * c) || (b * b == a * a + c * c) || c * c == (a * a + b * b)) {
		cout << "Yes";
	}
	else {
		cout << "No";
	}
	return 0;
}