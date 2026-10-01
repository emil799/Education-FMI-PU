package org.example.taskmanager.controllers;

import org.example.taskmanager.dto.TaskRequest;
import org.example.taskmanager.models.Task;
import org.example.taskmanager.models.TaskStatus;
import org.example.taskmanager.services.TaskService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/tasks")
public class TaskController {

    @Autowired
    private TaskService taskService;

    @PostMapping
    public ResponseEntity<?> createTask(@Valid @RequestBody TaskRequest taskRequest) {
        try {
            System.out.println("POST /tasks - Creating task: " + taskRequest.getTitle());

            Task task = new Task();
            task.setTitle(taskRequest.getTitle());
            task.setDescription(taskRequest.getDescription());
            task.setStatus(taskRequest.getStatus());
            task.setDueDate(taskRequest.getDueDate());

            Task createdTask = taskService.createTask(task);
            return ResponseEntity.status(HttpStatus.CREATED).body(createdTask);

        } catch (Exception e) {
            System.err.println("Error creating task: " + e.getMessage());
            e.printStackTrace();
            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR)
                    .body("Error creating task: " + e.getMessage());
        }
    }

    @GetMapping
    public ResponseEntity<List<Task>> getAllTasks(
            @RequestParam(required = false) TaskStatus status,
            @RequestParam(required = false) String sortBy) {

        System.out.println("GET /tasks - status: " + status + ", sortBy: " + sortBy);

        List<Task> tasks;

        if (status != null) {
            tasks = taskService.getTasksByStatus(status);
        } else if ("dueDate".equals(sortBy)) {
            tasks = taskService.getTasksSortedByDueDate(true);
        } else {
            tasks = taskService.getAllTasks();
        }

        return ResponseEntity.ok(tasks);
    }

    @GetMapping("/{id}")
    public ResponseEntity<Task> getTaskById(@PathVariable Long id) {
        System.out.println("GET /tasks/" + id);

        Optional<Task> task = taskService.getTaskById(id);
        return task.map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> updateTask(@PathVariable Long id,
                                        @Valid @RequestBody TaskRequest taskRequest) {
        try {
            System.out.println("PUT /tasks/" + id + " - Updating task");

            Task updatedTask = new Task();
            updatedTask.setTitle(taskRequest.getTitle());
            updatedTask.setDescription(taskRequest.getDescription());
            updatedTask.setStatus(taskRequest.getStatus());
            updatedTask.setDueDate(taskRequest.getDueDate());

            Optional<Task> task = taskService.updateTask(id, updatedTask);
            return task.map(ResponseEntity::ok)
                    .orElse(ResponseEntity.notFound().build());

        } catch (Exception e) {
            System.err.println("Error updating task: " + e.getMessage());
            e.printStackTrace();
            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR)
                    .body("Error updating task: " + e.getMessage());
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteTask(@PathVariable Long id) {
        System.out.println("DELETE /tasks/" + id);

        boolean deleted = taskService.deleteTask(id);
        return deleted ? ResponseEntity.noContent().build()
                : ResponseEntity.notFound().build();
    }
}