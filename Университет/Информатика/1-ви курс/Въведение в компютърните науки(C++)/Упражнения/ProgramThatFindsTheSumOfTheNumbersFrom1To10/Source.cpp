/*Напишете програма,която намира сумата на числата от 1 до 10.*/
#include <iostream>
using namespace std;
int main() {
	int i = 1;//инициализация
	int sum = 0;
	do {
		sum += i;//sum=sum+i - тяло на цикъла
		i++;//i=i+1 - управление на повторения
	} while (i <= 10);//условие за край
	cout << "sum=" << sum << endl;
	return 0;
}