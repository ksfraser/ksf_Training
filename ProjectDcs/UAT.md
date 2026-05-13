# UAT Plan - ksf_Training

## Document Information
- **Module**: ksf_Training
- **Version**: 1.0.0
- **Date**: 2026-05-13
- **Status**: Draft
- **Author**: KSFII Development Team

---

## 1. UAT Objectives

### 1.1 Primary Objectives
- Verify that the ksf_Training module meets all functional requirements defined in the Business Requirements document
- Validate that course creation, management, and enrollment workflows operate correctly
- Confirm that integration points with ksf_HRM, ksf_Performance, and ksf_Calendar function as specified
- Ensure certification tracking and compliance reporting meet business needs
- Obtain stakeholder sign-off before production deployment

### 1.2 Success Metrics
- All test scenarios pass with 100% pass rate
- No critical or high-severity defects remain open
- All integration endpoints verified functional
- Stakeholder acceptance confirmed

---

## 2. Scope of Testing

### 2.1 In Scope
| Area | Coverage |
|------|----------|
| Course Management | Create, edit, publish, archive training courses |
| Enrollment Management | Employee enrollment, status transitions, progress tracking |
| Certification Tracking | Certificate generation, validation, expiry management |
| Compliance Tracking | Compliance status reporting, alerts, audit trails |
| Calendar Integration | Training schedule synchronization with ksf_Calendar |
| HRM Integration | Employee data consumption from ksf_HRM |
| Performance Integration | Training data provision to ksf_Performance |

### 2.2 Out of Scope
- Unit testing of individual classes (covered in Test Plan)
- Database performance tuning
- Third-party external system integration beyond defined modules
- User interface regression testing (separate UAT)

---

## 3. Test Scenarios

### 3.1 Course Creation and Management

| ID | Test Scenario | Test Data | Expected Result |
|----|---------------|-----------|-----------------|
| TCM-01 | Create a new training course with all required fields | Title: "Safety Training Q2", Category: "Safety", Duration: "8 hours", Instructor: "John Doe" | Course created with STATUS_DRAFT, timestamps set correctly |
| TCM-02 | Create course with optional fields | Add description, category specification | All fields persisted correctly |
| TCM-03 | Publish a draft course | Course ID from TCM-01, status: published | Course status changes to STATUS_PUBLISHED, course visible in published list |
| TCM-04 | Archive a published course | Published course ID | Course status changes to STATUS_ARCHIVED, removed from active listings |
| TCM-05 | Edit course metadata | Update title, instructor, duration | Changes persisted, updated_at timestamp updated |
| TCM-06 | Retrieve single course by ID | Valid course ID | Correct course data returned |
| TCM-07 | Retrieve all published courses | - | Only STATUS_PUBLISHED courses returned |
| TCM-08 | Validate course without required fields | Missing title | Appropriate validation error thrown |
| TCM-09 | Create course with duplicate title | Existing course title | Allow creation (no uniqueness constraint by default) |

### 3.2 Training Enrollment

| ID | Test Scenario | Test Data | Expected Result |
|----|---------------|-----------|-----------------|
| ENR-01 | Enroll employee in published course | Valid course ID, employee ID: 1001 | Enrollment created with STATUS_ENROLLED, enrolled_at timestamp set |
| ENR-02 | Enroll employee in non-existent course | Invalid course ID | Error returned or null enrollment |
| ENR-03 | Start enrolled course | Enrollment ID from ENR-01 | Status changes to STATUS_IN_PROGRESS, started_at timestamp set |
| ENR-04 | Update course progress | Progress percentage: 50% | Progress field updated correctly |
| ENR-05 | Complete course for employee | Enrollment in progress | Status changes to STATUS_COMPLETED, completed_at set, progress = 100% |
| ENR-06 | Cancel enrollment | Enrollment ID | Status changes to STATUS_CANCELLED |
| ENR-07 | Retrieve enrollment by ID | Valid enrollment ID | Correct enrollment data returned |
| ENR-08 | Get all enrollments for employee | Employee ID: 1001 | All enrollments for that employee returned |
| ENR-09 | Enroll same employee in same course twice | Employee already enrolled | Second enrollment created (no duplicate prevention assumed) |
| ENR-10 | Progress validation - invalid percentage | Progress: 150% | Value should be clamped or validation error |

### 3.3 Certification Tracking

| ID | Test Scenario | Test Data | Expected Result |
|----|---------------|-----------|-----------------|
| CERT-01 | Certificate URL generated on completion | Completed enrollment | Certificate URL populated in enrollment record |
| CERT-02 | Verify certificate URL format | URL from CERT-01 | Valid URL format (https://...) |
| CERT-03 | Retrieve certificate for completed enrollment | Completed enrollment ID | Certificate URL returned |
| CERT-04 | Check certificate null for incomplete enrollment | Enrolled or in-progress enrollment | Certificate URL remains null |
| CERT-05 | Certificate link persistence | Multiple retrieval attempts | Same certificate URL returned consistently |

### 3.4 Compliance Tracking

| ID | Test Scenario | Test Data | Expected Result |
|----|---------------|-----------|-----------------|
| COMP-01 | Identify non-compliant employees | Employees without required course completions | System can identify compliance gaps |
| COMP-02 | Generate compliance status report | All active employees | Report shows compliance status per employee |
| COMP-03 | Track mandatory training completion | Required course list | System verifies completion of all mandatory courses |
| COMP-04 | Compliance alert triggers | Overdue training identified | System can flag training that requires attention |

### 3.5 Calendar Integration (ksf_Calendar)

| ID | Test Scenario | Test Data | Expected Result |
|----|---------------|-----------|-----------------|
| CAL-01 | Training schedule sync - course creation | New published course with schedule | Training event created in ksf_Calendar |
| CAL-02 | Training schedule sync - course update | Modified course dates | Calendar event updated accordingly |
| CAL-03 | Training schedule sync - course cancellation | Archived course | Calendar event removed or marked cancelled |
| CAL-04 | Retrieve calendar events for training | Date range | Training events returned from calendar |
| CAL-05 | Verify calendar data format | Event from ksf_Calendar | Event contains required fields (title, datetime, location) |
| CAL-06 | Handle calendar service unavailable | ksf_Calendar not reachable | System handles gracefully, logs error |

### 3.6 Employee Data Integration (ksf_HRM)

| ID | Test Scenario | Test Data | Expected Result |
|----|---------------|-----------|-----------------|
| HRM-01 | Consume employee data from ksf_HRM | Employee records with IDs, names, departments | Training module receives valid employee data |
| HRM-02 | Verify employee data structure | Employee record | Contains required fields: id, name, department, email |
| HRM-03 | Handle missing employee data | Employee ID not in HRM | Appropriate handling (exclude from enrollment or error) |
| HRM-04 | Training history provided to HRM | Completed training records | ksf_HRM receives training history data |
| HRM-05 | Certification data provided to HRM | Certificate records | ksf_HRM receives certification information |
| HRM-06 | Employee enrollment count sync | Employee with multiple enrollments | HRM receives accurate enrollment count |

### 3.7 Performance Review Integration (ksf_Performance)

| ID | Test Scenario | Test Data | Expected Result |
|----|---------------|-----------|-----------------|
| PERF-01 | Training data provided for review cycle | Employee ID, review period | ksf_Performance receives relevant training data |
| PERF-02 | Include completed courses in review data | Completed enrollments | Course completions included in training data export |
| PERF-03 | Include in-progress training in review data | Active enrollments | Ongoing training included with progress percentage |
| PERF-04 | Training data for specific employee | Employee ID: 1001 | Only that employee's training data included |
| PERF-05 | Date range filtering for review period | Review start/end dates | Only training within date range included |
| PERF-06 | Handle no training data scenario | Employee with no enrollments | Empty but valid response returned |

---

## 4. Test Data Requirements

### 4.1 Required Test Data

| Data Type | Description | Quantity |
|-----------|-------------|----------|
| Employees | Valid employee records from ksf_HRM | Min 10 employees |
| Courses | Mix of draft, published, archived | Min 15 courses |
| Enrollments | Various statuses (enrolled, in_progress, completed, cancelled) | Min 30 enrollments |
| Certificates | Completed course certificates | Min 10 certificates |
| Departments | Various departments for employee variety | Min 5 departments |

### 4.2 Test Data Setup

```
Employee IDs: 1001 - 1010
Course IDs: 1 - 15
Enrollment IDs: 1 - 30

Employee Sample:
- ID: 1001, Name: "Alice Smith", Department: "Engineering"
- ID: 1002, Name: "Bob Johnson", Department: "Sales"
- ID: 1003, Name: "Carol Williams", Department: "HR"

Course Sample:
- ID: 1, Title: "Safety Training Q2", Status: "published"
- ID: 2, Title: "Leadership Workshop", Status: "published"
- ID: 3, Title: "Technical Certification", Status: "draft"

Enrollment Sample:
- ID: 1, Course: 1, Employee: 1001, Status: "completed"
- ID: 2, Course: 2, Employee: 1001, Status: "in_progress"
- ID: 3, Course: 1, Employee: 1002, Status: "enrolled"
```

### 4.3 Integration Test Data

| Integration | Required Data |
|-------------|---------------|
| ksf_Calendar | Valid calendar events with datetime, title, location |
| ksf_HRM | Employee records with id, name, department, email |
| ksf_Performance | Review cycle dates, employee performance periods |

---

## 5. Success Criteria

### 5.1 Test Execution Criteria

| Criterion | Threshold | Measurement |
|-----------|-----------|--------------|
| Test Case Pass Rate | 100% | All executed test cases must pass |
| Critical Defects | 0 open | No open critical/high severity defects |
| High Priority Defects | Max 2 open | Limited high priority defects allowed |
| Medium/Low Defects | No limit | Tracked for next release |

### 5.2 Functional Criteria

| Area | Criteria |
|------|----------|
| Course Management | All CRUD operations function correctly |
| Enrollment | Status transitions work as specified |
| Integration | All module integrations verified |
| Data Integrity | No data loss during operations |

### 5.3 Integration Criteria

| Integration | Success Condition |
|-------------|-------------------|
| ksf_HRM | Employee data consumed correctly; training data provided correctly |
| ksf_Calendar | Events synchronized bidirectionally |
| ksf_Performance | Training data exported correctly for review cycles |

---

## 6. Sign-off Section

### 6.1 Test Execution Summary

| Metric | Value |
|--------|-------|
| Total Test Scenarios | 55 |
| Executed | 0 |
| Passed | 0 |
| Failed | 0 |
| Blocked | 0 |

### 6.2 Defect Summary

| Severity | Open | Closed | Total |
|----------|------|--------|-------|
| Critical | 0 | 0 | 0 |
| High | 0 | 0 | 0 |
| Medium | 0 | 0 | 0 |
| Low | 0 | 0 | 0 |

### 6.3 Sign-off Approval

| Role | Name | Signature | Date |
|------|------|-----------|------|
| Business Owner | | | |
| Project Manager | | | |
| QA Lead | | | |
| Technical Lead | | | |
| End User Representative | | | |

### 6.4 Comments and Conditions

> _Enter any conditions, reservations, or notes from sign-off participants._

---

### 6.5 Document History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0.0 | 2026-05-13 | KSFII Development Team | Initial version |

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-13*