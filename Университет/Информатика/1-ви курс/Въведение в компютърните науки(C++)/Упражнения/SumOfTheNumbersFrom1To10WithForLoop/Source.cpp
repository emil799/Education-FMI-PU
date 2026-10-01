/*Сума на числата от 1 до 10 с цикъл for.*/
#include <iostream>
using namespace std;
int main() {
	for (int i = 1; i <= 10; i++){
		sum=sum+i;//sum +=i
	}
	cout << "Sum=" << sum << endl;
	int n;
	int j = 0;
	do {
		if (j == 0) {
			cout << "n=";
			cin >> n;
			j++;
		}
		else {
			cout << "Въведете положително число:";
		}
	} while(n <= 0);
	int p = 1;
	for (int i = 1; i <= n; i++) {
		p = p * i;
	}
	cout << n << "!=" << p << endl;
}
