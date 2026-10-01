package org.example.taskmanager.models;


public enum TaskStatus {
    PENDING("В ОЧАКВАНЕ"),
    IN_PROGRESS("В ПРОЦЕС НА РАБОТА"),
    COMPLETED("ЗАВЪРШЕНА");

    private final String displayName;

    TaskStatus(String displayName) {
        this.displayName = displayName;
    }

    public String getDisplayName() {
        return displayName;
    }
}
