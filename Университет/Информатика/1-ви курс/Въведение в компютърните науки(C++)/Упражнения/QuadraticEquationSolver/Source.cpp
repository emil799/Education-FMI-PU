#include <iostream>
#include <math.h>
using namespace std;

int main()
{
	double a, b, c, D, x1, x2;
	cout << "Enter values for a, b, c:" << endl;
	cin >> a >> b >> c;
	if (cin.fail()) {
		cout << "Invalid values!" << endl;
		return 1;
	}
	if (!a) {
		x1 = -c / b;
		cout << "One root: " << x1 << endl;
	}
	else {
		D = b * b - 4 * a * c;
		if (D < 0) {
			cout << "There are no real roots!" << endl;
		}
		else if (!D) {
			x1 = -b / (2 * a);
			cout << "One root: " << x1 << endl;
		}
		else {
			D = sqrt(D);
			x1 = (-b - D) / (2 * a);
			x2 = (-b + D) / (2 * a);
			cout << "Two roots: " << endl;
			cout << "x1 = " << x1 << ", x2 = " << x2 << endl;
		}
	}
	return 0;
}