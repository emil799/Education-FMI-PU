package com.fmi.solarparkapp.services;

import com.fmi.solarparkapp.models.base.ProjectModel;
import com.fmi.solarparkapp.models.dto.ProjectBasicDto;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ProjectService {
    private final JdbcTemplate jdbcTemplate;

    public ProjectService(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }

    public List<ProjectBasicDto> fetchAllProjectsBasic() {
        String sql = "SELECT id, name, cost, customer_id FROM td_projects WHERE is_active = 1";
        return jdbcTemplate.query(sql, (rs, rowNum) -> {
            ProjectBasicDto project = new ProjectBasicDto();
            project.setId(rs.getInt("id"));
            project.setName(rs.getString("name"));
            project.setCost(rs.getDouble("cost"));
            project.setCustomerId(rs.getInt("customer_id"));
            return project;
        });
    }

    public List<ProjectModel> fetchAllProjects() {
        String sql = "SELECT * FROM td_projects WHERE is_active = 1";
        return jdbcTemplate.query(sql, (rs, rowNum) -> {
            ProjectModel project = new ProjectModel();
            project.setId(rs.getInt("id"));
            project.setName(rs.getString("name"));
            project.setCost(rs.getDouble("cost"));
            project.setCustomerId(rs.getInt("customer_id"));
            project.setIsActive(rs.getInt("is_active"));
            return project;
        });
    }

    public List<ProjectModel> fetchProjectsByCustomerId(int customerId) {
        String sql = "SELECT * FROM td_projects WHERE customer_id = ? AND is_active = 1";
        return jdbcTemplate.query(sql, new Object[]{customerId}, (rs, rowNum) -> {
            ProjectModel project = new ProjectModel();
            project.setId(rs.getInt("id"));
            project.setName(rs.getString("name"));
            project.setCost(rs.getDouble("cost"));
            project.setCustomerId(rs.getInt("customer_id"));
            project.setIsActive(rs.getInt("is_active"));
            return project;
        });
    }

    public ProjectModel fetchProjectById(int id) {
        String sql = "SELECT * FROM td_projects WHERE id = ? AND is_active = 1";
        var collection = jdbcTemplate.query(sql, new Object[]{id}, (rs, rowNum) -> {
            ProjectModel project = new ProjectModel();
            project.setId(rs.getInt("id"));
            project.setName(rs.getString("name"));
            project.setCost(rs.getDouble("cost"));
            project.setCustomerId(rs.getInt("customer_id"));
            project.setIsActive(rs.getInt("is_active"));
            return project;
        });
        return collection.isEmpty() ? null : collection.get(0);
    }

    public boolean createNewProject(ProjectModel model) {
        String sql = "INSERT INTO td_projects (name, cost, customer_id) VALUES (?, ?, ?)";
        int result = jdbcTemplate.update(sql, model.getName(), model.getCost(), model.getCustomerId());
        return result > 0;
    }

    public boolean updateProject(int id, ProjectModel model) {
        String sql = "UPDATE td_projects SET name = ?, cost = ?, customer_id = ? WHERE id = ? AND is_active = 1";
        int result = jdbcTemplate.update(sql, model.getName(), model.getCost(), model.getCustomerId(), id);
        return result > 0;
    }

    public boolean softDeleteProject(int id) {
        String sql = "UPDATE td_projects SET is_active = 0 WHERE id = ?";
        int result = jdbcTemplate.update(sql, id);
        return result > 0;
    }
}
