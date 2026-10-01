package com.fmi.solarparkapp.services;

import com.fmi.solarparkapp.models.base.ContactModel;
import com.fmi.solarparkapp.models.dto.ContactBasicDto;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ContactService {
    private final JdbcTemplate jdbcTemplate;

    public ContactService(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }


    public List<ContactBasicDto> fetchAllContactsBasic() {
        String sql = "SELECT id, first_name, last_name, email, phone FROM td_contacts WHERE is_active = 1";
        return jdbcTemplate.query(sql, (rs, rowNum) -> {
            ContactBasicDto contact = new ContactBasicDto();
            contact.setId(rs.getInt("id"));
            contact.setFirstName(rs.getString("first_name"));
            contact.setLastName(rs.getString("last_name"));
            contact.setEmail(rs.getString("email"));
            contact.setPhone(rs.getString("phone"));
            return contact;
        });
    }

    public List<ContactModel> fetchAllContacts() {
        String sql = "SELECT * FROM td_contacts WHERE is_active = 1";
        return jdbcTemplate.query(sql, (rs, rowNum) -> {
            ContactModel contact = new ContactModel();
            contact.setId(rs.getInt("id"));
            contact.setFirstName(rs.getString("first_name"));
            contact.setLastName(rs.getString("last_name"));
            contact.setEmail(rs.getString("email"));
            contact.setPhone(rs.getString("phone"));
            contact.setIsActive(rs.getInt("is_active"));
            return contact;
        });
    }

    public List<ContactModel> fetchContactsByProjectId(int projectId) {
        String sql = "SELECT c.* FROM td_contacts c " +
                "INNER JOIN tc_project_contact pc ON c.id = pc.contact_id " +
                "WHERE pc.project_id = ? AND c.is_active = 1";
        return jdbcTemplate.query(sql, new Object[]{projectId}, (rs, rowNum) -> {
            ContactModel contact = new ContactModel();
            contact.setId(rs.getInt("id"));
            contact.setFirstName(rs.getString("first_name"));
            contact.setLastName(rs.getString("last_name"));
            contact.setEmail(rs.getString("email"));
            contact.setPhone(rs.getString("phone"));
            contact.setIsActive(rs.getInt("is_active"));
            return contact;
        });
    }

    public ContactModel fetchContactById(int id) {
        String sql = "SELECT * FROM td_contacts WHERE id = ? AND is_active = 1";
        var collection = jdbcTemplate.query(sql, new Object[]{id}, (rs, rowNum) -> {
            ContactModel contact = new ContactModel();
            contact.setId(rs.getInt("id"));
            contact.setFirstName(rs.getString("first_name"));
            contact.setLastName(rs.getString("last_name"));
            contact.setEmail(rs.getString("email"));
            contact.setPhone(rs.getString("phone"));
            contact.setIsActive(rs.getInt("is_active"));
            return contact;
        });
        return collection.isEmpty() ? null : collection.get(0);
    }

    public boolean createNewContact(ContactModel model) {
        String sql = "INSERT INTO td_contacts (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)";
        int result = jdbcTemplate.update(sql, model.getFirstName(), model.getLastName(), model.getEmail(), model.getPhone());
        return result > 0;
    }

    public boolean updateContact(int id, ContactModel model) {
        String sql = "UPDATE td_contacts SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ? AND is_active = 1";
        int result = jdbcTemplate.update(sql, model.getFirstName(), model.getLastName(), model.getEmail(), model.getPhone(), id);
        return result > 0;
    }

    public boolean softDeleteContact(int id) {
        String sql = "UPDATE td_contacts SET is_active = 0 WHERE id = ?";
        int result = jdbcTemplate.update(sql, id);
        return result > 0;
    }

    public boolean assignContactToProject(int projectId, int contactId) {
        String sql = "INSERT INTO tc_project_contact (project_id, contact_id) VALUES (?, ?)";
        int result = jdbcTemplate.update(sql, projectId, contactId);
        return result > 0;
    }
}
