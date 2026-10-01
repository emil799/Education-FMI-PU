/*Сума на четни в интервала [m;n].*/
#include <iostream>
using namespace std;
int main() {
	int a[5];
	for (int i = 0; i < 5; i++) {
		cout << "a[" << i << "]=";
		cin >> a[i];
	}
	for (int i = 0; i < 5; i++) {
		cout << a[i] << endl;
	}
	int sum = 0;
	for (int i = 0; i < 5; i++) {
		sum = sum + a[i];
	}
	cout << "Sum=" << sum << endl;
	double average = sum / 5;
	cout << "Average=" << average << endl;
	int max = a[0];
	int index_max = 0;;
	for (int i = 0; i < 5; i++) {
		if (a[i] > max) {
			max = a[i];
			index_max = i;
		}
	}
	cout << "Max stojnost=" << max <<" i tozi element ima index"<< endl;
	int br = 0;
	for (int i = 0; i < 5; i++) {
		if (a[i] > 5) {
			br++;
		}
	}
	cout << "Broqt na elementite sus stojnost 5 e:" << br << endl;
	return 0;
}