package com.fmi.solarparkapp.controllers;

import com.fmi.solarparkapp.http.AppResponse;
import com.fmi.solarparkapp.models.base.ContactModel;
import com.fmi.solarparkapp.services.ContactService;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/contacts")
public class ContactController {
    private final ContactService contactService;

    public ContactController(ContactService contactService) {
        this.contactService = contactService;
    }

    @GetMapping("/basic")
    public ResponseEntity<?> fetchAllContactsBasic() {
        return AppResponse.success()
                .withData(contactService.fetchAllContactsBasic())
                .send();
    }

    @GetMapping
    public ResponseEntity<?> fetchAllContacts() {
        return AppResponse.success()
                .withData(contactService.fetchAllContacts())
                .send();
    }

    @GetMapping("/project/{projectId}")
    public ResponseEntity<?> fetchContactsByProjectId(@PathVariable int projectId) {
        return AppResponse.success()
                .withData(contactService.fetchContactsByProjectId(projectId))
                .send();
    }

    @GetMapping("/{id}")
    public ResponseEntity<?> fetchContactById(@PathVariable int id) {
        ContactModel model = contactService.fetchContactById(id);
        if(model == null) {
            return AppResponse.error()
                    .withCode(HttpStatus.NOT_FOUND)
                    .withMessage("Contact not found")
                    .send();
        }
        return AppResponse.success()
                .withData(model)
                .send();
    }

    @PostMapping
    public ResponseEntity<?> createNewContact(@RequestBody ContactModel contact) {
        if(contactService.createNewContact(contact)) {
            return AppResponse.success()
                    .withMessage("New contact created")
                    .send();
        }
        return AppResponse.error()
                .withMessage("Cannot create contact")
                .send();
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> updateContact(@PathVariable int id, @RequestBody ContactModel contact) {
        if(contactService.updateContact(id, contact)) {
            return AppResponse.success()
                    .withMessage("Contact updated")
                    .send();
        }
        return AppResponse.error()
                .withCode(HttpStatus.NOT_FOUND)
                .withMessage("Contact not found or cannot be updated")
                .send();
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<?> deleteContact(@PathVariable int id) {
        if(contactService.softDeleteContact(id)) {
            return AppResponse.success()
                    .withMessage("Contact deleted")
                    .send();
        }
        return AppResponse.error()
                .withCode(HttpStatus.NOT_FOUND)
                .withMessage("Contact not found")
                .send();
    }

    @PostMapping("/{contactId}/assign/{projectId}")
    public ResponseEntity<?> assignContactToProject(@PathVariable int contactId, @PathVariable int projectId) {
        if(contactService.assignContactToProject(projectId, contactId)) {
            return AppResponse.success()
                    .withMessage("Contact assigned to project")
                    .send();
        }
        return AppResponse.error()
                .withMessage("Cannot assign contact to project")
                .send();
    }
}
