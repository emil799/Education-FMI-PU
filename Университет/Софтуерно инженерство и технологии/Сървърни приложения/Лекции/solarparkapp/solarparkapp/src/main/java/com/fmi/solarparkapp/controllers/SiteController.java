package com.fmi.solarparkapp.controllers;

import com.fmi.solarparkapp.http.AppResponse;
import com.fmi.solarparkapp.models.base.SiteModel;
import com.fmi.solarparkapp.services.SiteService;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/sites")
public class SiteController {
    private final SiteService siteService;

    public SiteController(SiteService siteService) {
        this.siteService = siteService;
    }

    @GetMapping
    public ResponseEntity<?> fetchAllSites() {
        return AppResponse.success()
                .withData(siteService.fetchAllSites())
                .send();
    }

    @GetMapping("/basic")
    public ResponseEntity<?> fetchAllSitesBasic() {
        return AppResponse.success()
                .withData(siteService.fetchAllSitesBasic())
                .send();
    }

    @GetMapping("/project/{projectId}")
    public ResponseEntity<?> fetchSitesByProjectId(@PathVariable int projectId) {
        return AppResponse.success()
                .withData(siteService.fetchSitesByProjectId(projectId))
                .send();
    }

    @GetMapping("/{id}")
    public ResponseEntity<?> fetchSiteById(@PathVariable int id) {
        SiteModel model = siteService.fetchSiteById(id);
        if(model == null) {
            return AppResponse.error()
                    .withCode(HttpStatus.NOT_FOUND)
                    .withMessage("Site not found")
                    .send();
        }
        return AppResponse.success()
                .withData(model)
                .send();
    }

    @PostMapping
    public ResponseEntity<?> createNewSite(@RequestBody SiteModel site) {
        if(siteService.createNewSite(site)) {
            return AppResponse.success()
                    .withMessage("New site created")
                    .send();
        }
        return AppResponse.error()
                .withMessage("Cannot create site")
                .send();
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> updateSite(@PathVariable int id, @RequestBody SiteModel site) {
        if(siteService.updateSite(id, site)) {
            return AppResponse.success()
                    .withMessage("Site updated")
                    .send();
        }
        return AppResponse.error()
                .withCode(HttpStatus.NOT_FOUND)
                .withMessage("Site not found or cannot be updated")
                .send();
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<?> deleteSite(@PathVariable int id) {
        if(siteService.softDeleteSite(id)) {
            return AppResponse.success()
                    .withMessage("Site deleted")
                    .send();
        }
        return AppResponse.error()
                .withCode(HttpStatus.NOT_FOUND)
                .withMessage("Site not found")
                .send();
    }
}
