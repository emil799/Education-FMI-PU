#include <iostream>
using namespace std;

int main() {
    // Declare variables
    float gpa, highestGPA, lowestGPA, totalGPA = 0;
    int students, excellentResults = 0, consecutiveExcellent = 0;

    // Input number of students
    cout << "Enter the number of students: ";
    cin >> students;

    // Input and calculate GPA for each student
    for (int i = 1; i <= students; i++) {
        cout << "Enter the GPA for student " << i << ": ";
        cin >> gpa;

        totalGPA += gpa; // Add to total GPA

        // Check for highest and lowest GPA
        if (i == 1) {
            highestGPA = gpa;
            lowestGPA = gpa;
        }
        else {
            if (gpa > highestGPA) {
                highestGPA = gpa;
            }
            if (gpa < lowestGPA) {
                lowestGPA = gpa;
            }
        }

        // Check for excellent results
        if (gpa >= 5.50) {
            excellentResults++;
            consecutiveExcellent++;
        }
        else {
            consecutiveExcellent = 0;
        }
    }

    // Output results
    cout << "Highest GPA: " << highestGPA << endl;
    cout << "Lowest GPA: " << lowestGPA << endl;
    cout << "Course GPA: " << (totalGPA / students) << endl;
    cout << "Number of students with excellent results: " << excellentResults << endl;
    cout << "Consecutive number of students with excellent results: " << consecutiveExcellent << endl;

    return 0;
}