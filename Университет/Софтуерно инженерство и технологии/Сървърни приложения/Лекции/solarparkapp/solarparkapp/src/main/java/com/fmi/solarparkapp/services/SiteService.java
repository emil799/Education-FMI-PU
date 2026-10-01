package com.fmi.solarparkapp.services;

import com.fmi.solarparkapp.models.base.SiteModel;
import com.fmi.solarparkapp.models.dto.SiteBasicDto;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class SiteService {
    private final JdbcTemplate jdbcTemplate;

    public SiteService(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }


    public List<SiteBasicDto> fetchAllSitesBasic() {
        String sql = "SELECT id, name, address, config_cost, other_cost, project_id FROM td_sites WHERE is_active = 1";
        return jdbcTemplate.query(sql, (rs, rowNum) -> {
            SiteBasicDto site = new SiteBasicDto();
            site.setId(rs.getInt("id"));
            site.setName(rs.getString("name"));
            site.setAddress(rs.getString("address"));
            site.setConfigCost(rs.getDouble("config_cost"));
            site.setOtherCost(rs.getDouble("other_cost"));
            site.setProjectId(rs.getInt("project_id"));
            return site;
        });
    }

    public List<SiteModel> fetchAllSites() {
        String sql = "SELECT * FROM td_sites WHERE is_active = 1";
        return jdbcTemplate.query(sql, (rs, rowNum) -> {
            SiteModel site = new SiteModel();
            site.setId(rs.getInt("id"));
            site.setName(rs.getString("name"));
            site.setAddress(rs.getString("address"));
            site.setConfigCost(rs.getDouble("config_cost"));
            site.setOtherCost(rs.getDouble("other_cost"));
            site.setProjectId(rs.getInt("project_id"));
            site.setIsActive(rs.getInt("is_active"));
            return site;
        });
    }

    public List<SiteModel> fetchSitesByProjectId(int projectId) {
        String sql = "SELECT * FROM td_sites WHERE project_id = ? AND is_active = 1";
        return jdbcTemplate.query(sql, new Object[]{projectId}, (rs, rowNum) -> {
            SiteModel site = new SiteModel();
            site.setId(rs.getInt("id"));
            site.setName(rs.getString("name"));
            site.setAddress(rs.getString("address"));
            site.setConfigCost(rs.getDouble("config_cost"));
            site.setOtherCost(rs.getDouble("other_cost"));
            site.setProjectId(rs.getInt("project_id"));
            site.setIsActive(rs.getInt("is_active"));
            return site;
        });
    }

    public SiteModel fetchSiteById(int id) {
        String sql = "SELECT * FROM td_sites WHERE id = ? AND is_active = 1";
        var collection = jdbcTemplate.query(sql, new Object[]{id}, (rs, rowNum) -> {
            SiteModel site = new SiteModel();
            site.setId(rs.getInt("id"));
            site.setName(rs.getString("name"));
            site.setAddress(rs.getString("address"));
            site.setConfigCost(rs.getDouble("config_cost"));
            site.setOtherCost(rs.getDouble("other_cost"));
            site.setProjectId(rs.getInt("project_id"));
            site.setIsActive(rs.getInt("is_active"));
            return site;
        });
        return collection.isEmpty() ? null : collection.get(0);
    }

    public boolean createNewSite(SiteModel model) {
        String sql = "INSERT INTO td_sites (name, address, config_cost, other_cost, project_id) VALUES (?, ?, ?, ?, ?)";
        int result = jdbcTemplate.update(sql, model.getName(), model.getAddress(), model.getConfigCost(), model.getOtherCost(), model.getProjectId());
        return result > 0;
    }

    public boolean updateSite(int id, SiteModel model) {
        String sql = "UPDATE td_sites SET name = ?, address = ?, config_cost = ?, other_cost = ?, project_id = ? WHERE id = ? AND is_active = 1";
        int result = jdbcTemplate.update(sql, model.getName(), model.getAddress(), model.getConfigCost(), model.getOtherCost(), model.getProjectId(), id);
        return result > 0;
    }

    public boolean softDeleteSite(int id) {
        String sql = "UPDATE td_sites SET is_active = 0 WHERE id = ?";
        int result = jdbcTemplate.update(sql, id);
        return result > 0;
    }
}
