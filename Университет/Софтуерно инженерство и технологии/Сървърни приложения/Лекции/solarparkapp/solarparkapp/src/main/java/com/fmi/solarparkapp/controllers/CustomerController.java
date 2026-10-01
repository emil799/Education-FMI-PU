package com.fmi.solarparkapp.controllers;

import com.fmi.solarparkapp.http.AppResponse;
import com.fmi.solarparkapp.models.base.CustomerModel;
import com.fmi.solarparkapp.services.CustomerService;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/customers")
public class CustomerController {
    private final CustomerService customerService;

    public CustomerController(CustomerService customerService) {
        this.customerService = customerService;
    }

    @GetMapping("/basic")
    public ResponseEntity<?> fetchAllCustomersBasic() {
        return AppResponse.success()
                .withData(customerService.fetchAllCustomersBasic())
                .send();
    }

    @GetMapping
    public ResponseEntity<?> fetchAllCustomers() {
        return AppResponse.success()
                .withData(customerService.fetchAllCustomers())
                .send();
    }

    @GetMapping("/{id}")
    public ResponseEntity<?> fetchCustomerById(@PathVariable int id) {
        CustomerModel model = customerService.fetchCustomerById(id);
        if(model == null) {
            return AppResponse.error()
                    .withCode(HttpStatus.NOT_FOUND)
                    .withMessage("Customer not found")
                    .send();
        }
        return AppResponse.success()
                .withData(model)
                .send();
    }

    @PostMapping
    public ResponseEntity<?> createNewCustomer(@RequestBody CustomerModel customer) {
        if(customerService.createNewCustomer(customer)) {
            return AppResponse.success()
                    .withMessage("New customer created")
                    .send();
        }
        return AppResponse.error()
                .withMessage("Cannot create customer")
                .send();
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> updateCustomer(@PathVariable int id, @RequestBody CustomerModel customer) {
        if(customerService.updateCustomer(id, customer)) {
            return AppResponse.success()
                    .withMessage("Customer updated")
                    .send();
        }
        return AppResponse.error()
                .withCode(HttpStatus.NOT_FOUND)
                .withMessage("Customer not found or cannot be updated")
                .send();
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<?> deleteCustomer(@PathVariable int id) {
        if(customerService.softDeleteCustomer(id)) {
            return AppResponse.success()
                    .withMessage("Customer deleted")
                    .send();
        }
        return AppResponse.error()
                .withCode(HttpStatus.NOT_FOUND)
                .withMessage("Customer not found")
                .send();
    }
}