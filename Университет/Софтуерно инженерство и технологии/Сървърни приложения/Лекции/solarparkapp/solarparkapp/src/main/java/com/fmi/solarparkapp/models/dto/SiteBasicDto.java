package com.fmi.solarparkapp.models.dto;

public class SiteBasicDto {
    private int id;
    private String name;
    private String address;
    private Double configCost;
    private Double otherCost;
    private Integer projectId;

    // Getters and Setters
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public Double getConfigCost() {
        return configCost;
    }

    public void setConfigCost(Double configCost) {
        this.configCost = configCost;
    }

    public Double getOtherCost() {
        return otherCost;
    }

    public void setOtherCost(Double otherCost) {
        this.otherCost = otherCost;
    }

    public Integer getProjectId() {
        return projectId;
    }

    public void setProjectId(Integer projectId) {
        this.projectId = projectId;
    }
}
