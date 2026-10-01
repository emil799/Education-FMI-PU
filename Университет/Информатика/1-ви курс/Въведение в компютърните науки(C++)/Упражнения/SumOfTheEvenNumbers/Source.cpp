/*Сума на четни в интервала [m;n].*/
#include <iostream>
using namespace std;
int main() {
	int sum = 0;
	int m, n;
	cout << "m=";
	cin >> m;
	do {
		cout << "n=";
		cin >> n;
	} while (n <= m);
	int i;
	if (m % 2 == 1) {
		i = m;
	}
	else {
		i = m + 1;
	}for (i; i <= n; i = i + 2) {
		sum = sum + i;//sum +=i
	}cout << "Sum=" << sum << endl;
}