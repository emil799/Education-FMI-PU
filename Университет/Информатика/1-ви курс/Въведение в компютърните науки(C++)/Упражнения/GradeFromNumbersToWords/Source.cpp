/*Съставете програма,която въвежда получена оценка с цифри и я извежда с думи.*/
#include <iostream>
using namespace std;
int main() {
	int grade;
	cout << "Enter a grade:";
	cin >> grade;
	switch (grade) {
	case 2:cout << "Fail"; break;
	case 3:cout << "Satisfactory"; break;
	case 4:cout << "Good"; break;
	case 5:cout << "Very good"; break;
	case 6:cout << "Excellent"; break;
	default:cout << "Error";
	}
	return 0;
}