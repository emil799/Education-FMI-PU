package com.fmi.solarparkapp.models.base;

public class SiteModel {
    private Integer id;
    private String name;
    private String address;
    private Double configCost;
    private Double otherCost;
    private Integer projectId;
    private Integer isActive = 1;

    // Getters and Setters
    public Integer getId() { return id; }
    public void setId(Integer id) { this.id = id; }
    public String getName() { return name; }
    public void setName(String name) { this.name = name; }
    public String getAddress() { return address; }
    public void setAddress(String address) { this.address = address; }
    public Double getConfigCost() { return configCost; }
    public void setConfigCost(Double configCost) { this.configCost = configCost; }
    public Double getOtherCost() { return otherCost; }
    public void setOtherCost(Double otherCost) { this.otherCost = otherCost; }
    public Integer getProjectId() { return projectId; }
    public void setProjectId(Integer projectId) { this.projectId = projectId; }
    public Integer getIsActive() { return isActive; }
    public void setIsActive(Integer isActive) { this.isActive = isActive; }
}
