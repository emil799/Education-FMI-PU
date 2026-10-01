#include <iostream>
using namespace std;
#include <cfloat>
#include <cmath>
#include <cstring>
#include <iomanip>
#include <numbers>

int main() {
	/*double d = 123.317;
	for (int k = 15; k < 40; ++k) {
		cout.precision(k);
		cout << setw(2) << "-->>" << d << endl;
	}
	*/
	//cout << DBL_MANT_DIG << endl;
	/*double d = 123.317, nd = trunc(d);
	cout.precision(22);
	cout << d << endl << d - nd << endl << d - nd + nd << endl;
	*/
	/*double d = 123.317;
	for (double n = 0.0000001; n < 0.001; n += 0.0000001) {
		if (d + n != d + n - trunc(d + n) + trunc(d + n)) {
			cout << d + n << endl;
			cout << "Край/n";
	}
	}
	*/
	/*double d = 123.317;
	double d2 = 0.01234567e100, d3 = d + 0.0012341e-100;
	cout << "d->>" << d << endl;
	cout << "d->>" << d / d2 * d2 << endl;
	cout << "d->>" << d * d3 / d3 << endl;
	cout << "d->>" << d + d2 - d2 << endl;
	*/
	double pi = 3.1415926535,
		rad = pi / 4.0;
	for (int k = 0; k < 10; ++k) {
		double x = rad + 2 * k * pi;
		cout << " " << sin(x) << endl;
		double s1 = x;
		s = x - x * x * x / 6, a = -x * x * 6, h = 5;
		while (s1 != s).
			a = -a * x * x / ((h - 1) * h);
		h += 2;
		s1 = s;
		s += -a;
	}
	cout << s << endl;
}