package org.example.taskmanager.services;

import org.example.taskmanager.models.Task;
import org.example.taskmanager.models.TaskStatus;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.util.*;
import java.util.concurrent.ConcurrentHashMap;
import java.util.concurrent.atomic.AtomicLong;
import java.util.stream.Collectors;

@Service
public class TaskService {
    private final Map<Long, Task> tasks = new ConcurrentHashMap<>();
    private final AtomicLong idCounter = new AtomicLong(1);

    public TaskService() {
        initializeSampleData();
    }

    private void initializeSampleData() {
        // Добавяме примерни задачи
        createTask(new Task(null, "Завърши домашното", "Да се завърши домашното по Spring Boot", TaskStatus.PENDING, LocalDate.now().plusDays(3)));
        createTask(new Task(null, "Проучи REST API", "Да се проучат принципите на RESTful API", TaskStatus.IN_PROGRESS, LocalDate.now().plusDays(1)));
        createTask(new Task(null, "Тествай приложението", "Да се напишат unit тестове", TaskStatus.COMPLETED, LocalDate.now().minusDays(1)));
    }

    public List<Task> getAllTasks() {
        return new ArrayList<>(tasks.values());
    }

    public Optional<Task> getTaskById(Long id) {
        return Optional.ofNullable(tasks.get(id));
    }

    public Task createTask(Task task) {
        Long newId = idCounter.getAndIncrement();
        task.setId(newId);
        tasks.put(newId, task);
        System.out.println("Created task: " + task.getId() + " - " + task.getTitle());
        return task;
    }

    public Optional<Task> updateTask(Long id, Task updatedTask) {
        if (tasks.containsKey(id)) {
            updatedTask.setId(id);
            tasks.put(id, updatedTask);
            System.out.println("Updated task: " + id + " - " + updatedTask.getTitle());
            return Optional.of(updatedTask);
        }
        System.out.println("Task not found for update: " + id);
        return Optional.empty();
    }

    public boolean deleteTask(Long id) {
        boolean removed = tasks.remove(id) != null;
        System.out.println("Deleted task: " + id + " - " + (removed ? "success" : "not found"));
        return removed;
    }

    public List<Task> getTasksByStatus(TaskStatus status) {
        return tasks.values().stream()
                .filter(task -> task.getStatus() == status)
                .collect(Collectors.toList());
    }

    public List<Task> getTasksSortedByDueDate(boolean ascending) {
        return tasks.values().stream()
                .sorted((t1, t2) -> {
                    LocalDate date1 = t1.getDueDate() != null ? t1.getDueDate() : LocalDate.MAX;
                    LocalDate date2 = t2.getDueDate() != null ? t2.getDueDate() : LocalDate.MAX;
                    return ascending ? date1.compareTo(date2) : date2.compareTo(date1);
                })
                .collect(Collectors.toList());
    }
}