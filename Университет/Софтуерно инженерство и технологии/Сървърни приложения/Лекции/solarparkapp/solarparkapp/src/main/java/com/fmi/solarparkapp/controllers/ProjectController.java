package com.fmi.solarparkapp.controllers;

import com.fmi.solarparkapp.http.AppResponse;
import com.fmi.solarparkapp.models.base.ProjectModel;
import com.fmi.solarparkapp.services.ProjectService;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/projects")
public class ProjectController {
    private final ProjectService projectService;

    public ProjectController(ProjectService projectService) {
        this.projectService = projectService;
    }

    @GetMapping("/basic")
    public ResponseEntity<?> fetchAllProjectsBasic() {
        return AppResponse.success()
                .withData(projectService.fetchAllProjectsBasic())
                .send();
    }

    @GetMapping
    public ResponseEntity<?> fetchAllProjects() {
        return AppResponse.success()
                .withData(projectService.fetchAllProjects())
                .send();
    }

    @GetMapping("/customer/{customerId}")
    public ResponseEntity<?> fetchProjectsByCustomerId(@PathVariable int customerId) {
        return AppResponse.success()
                .withData(projectService.fetchProjectsByCustomerId(customerId))
                .send();
    }

    @GetMapping("/{id}")
    public ResponseEntity<?> fetchProjectById(@PathVariable int id) {
        ProjectModel model = projectService.fetchProjectById(id);
        if(model == null) {
            return AppResponse.error()
                    .withCode(HttpStatus.NOT_FOUND)
                    .withMessage("Project not found")
                    .send();
        }
        return AppResponse.success()
                .withData(model)
                .send();
    }

    @PostMapping
    public ResponseEntity<?> createNewProject(@RequestBody ProjectModel project) {
        if(projectService.createNewProject(project)) {
            return AppResponse.success()
                    .withMessage("New project created")
                    .send();
        }
        return AppResponse.error()
                .withMessage("Cannot create project")
                .send();
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> updateProject(@PathVariable int id, @RequestBody ProjectModel project) {
        if(projectService.updateProject(id, project)) {
            return AppResponse.success()
                    .withMessage("Project updated")
                    .send();
        }
        return AppResponse.error()
                .withCode(HttpStatus.NOT_FOUND)
                .withMessage("Project not found or cannot be updated")
                .send();
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<?> deleteProject(@PathVariable int id) {
        if(projectService.softDeleteProject(id)) {
            return AppResponse.success()
                    .withMessage("Project deleted")
                    .send();
        }
        return AppResponse.error()
                .withCode(HttpStatus.NOT_FOUND)
                .withMessage("Project not found")
                .send();
    }
}
