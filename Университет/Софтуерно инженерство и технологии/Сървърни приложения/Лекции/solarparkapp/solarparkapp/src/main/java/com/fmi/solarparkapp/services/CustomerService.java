package com.fmi.solarparkapp.services;

import com.fmi.solarparkapp.models.base.CustomerModel;
import com.fmi.solarparkapp.models.dto.CustomerBasicDto;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class CustomerService {
    private final JdbcTemplate jdbcTemplate;

    public CustomerService(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }

    public List<CustomerBasicDto> fetchAllCustomersBasic() {
        String sql = "SELECT id, name FROM td_customers WHERE is_active = 1";
        return this.jdbcTemplate.query(sql, (rs, rowNum) -> {
            CustomerBasicDto customerDto = new CustomerBasicDto();
            customerDto.setId(rs.getInt("id"));
            customerDto.setName(rs.getString("name"));
            return customerDto;
        });
    }

    private List<CustomerModel> collectCustomers(String query) {
        return this.jdbcTemplate.query(query, (rs, rowNum) -> {
            CustomerModel customerModel = new CustomerModel();
            customerModel.setId(rs.getInt("id"));
            customerModel.setName(rs.getString("name"));
            customerModel.setNumberOfProjects(rs.getInt("number_of_projects"));
            customerModel.setIsActive(rs.getInt("is_active"));
            return customerModel;
        });
    }

    public List<CustomerModel> fetchAllCustomers() {
        String sql = "SELECT * FROM td_customers WHERE is_active = 1";
        return this.collectCustomers(sql);
    }

    public CustomerModel fetchCustomerById(int id) {
        String sql = "SELECT * FROM td_customers WHERE id = ? AND is_active = 1";
        var collection = this.jdbcTemplate.query(sql, new Object[]{id}, (rs, rowNum) -> {
            CustomerModel customerModel = new CustomerModel();
            customerModel.setId(rs.getInt("id"));
            customerModel.setName(rs.getString("name"));
            customerModel.setNumberOfProjects(rs.getInt("number_of_projects"));
            customerModel.setIsActive(rs.getInt("is_active"));
            return customerModel;
        });

        if(collection.isEmpty()) {
            return null;
        }
        return collection.get(0);
    }

    public boolean createNewCustomer(CustomerModel model) {
        String sql = "INSERT INTO td_customers (name, number_of_projects) VALUES (?, ?)";
        int result = jdbcTemplate.update(sql, model.getName(), model.getNumberOfProjects());
        return result > 0;
    }

    public boolean updateCustomer(int id, CustomerModel model) {
        String sql = "UPDATE td_customers SET name = ?, number_of_projects = ? WHERE id = ? AND is_active = 1";
        int result = jdbcTemplate.update(sql, model.getName(), model.getNumberOfProjects(), id);
        return result > 0;
    }

    public boolean softDeleteCustomer(int id) {
        String sql = "UPDATE td_customers SET is_active = 0 WHERE id = ?";
        int result = jdbcTemplate.update(sql, id);
        return result > 0;
    }
}