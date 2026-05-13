# Use Cases - ksf_Training Module

## Document Information
- **Module:** ksf_Training
- **Version:** 1.0.0
- **Last Updated:** 2026-05-13
- **Based On:** Business Requirements.md v1.0.0

---

## Table of Contents
1. [Create Training Course](#1-create-training-course)
2. [Enroll Employee in Course](#2-enroll-employee-in-course)
3. [Track Course Completion](#3-track-course-completion)
4. [Issue Certification](#4-issue-certification)
5. [Track Compliance Status](#5-track-compliance-status)
6. [Schedule Training Event](#6-schedule-training-event)
7. [View Training History](#7-view-training-history)
8. [Add Training to Performance Review](#8-add-training-to-performance-review)
9. [Set Mandatory Training Requirements](#9-set-mandatory-training-requirements)

---

## 1. Create Training Course

### Use Case: UC-001 - Create Training Course

| Field | Value |
|-------|-------|
| **Actor** | Training Administrator |
| **Description** | Training Administrator creates a new training course with curriculum details, duration, and certification requirements |
| **Pre-conditions** | User is authenticated as Training Administrator; ksf_HRM connection is available |
| **Post-conditions** | New course is created with unique ID; Course is available for enrollment |

### Main Flow

| Step | Actor | Action |
|------|-------|--------|
| 1 | Training Administrator | Navigate to Course Management |
| 2 | Training Administrator | Select "Create New Course" |
| 3 | Training Administrator | Enter course name, description, and category |
| 4 | Training Administrator | Define course duration (hours/days) |
| 5 | Training Administrator | Add curriculum modules/topics |
| 6 | Training Administrator | Configure certification requirements (if applicable) |
| 7 | Training Administrator | Set course capacity limits |
| 8 | Training Administrator | Define assessment criteria (passing score, retake policy) |
| 9 | Training Administrator | Save course |
| 10 | System | Validate course data and generate unique Course ID |
| 11 | System | Confirm course creation |

### Alternative Flows

| ID | Condition | Action |
|----|-----------|--------|
| AF-001a | Duplicate course name | System displays error; Administrator must enter unique name |
| AF-001b | Invalid duration format | System prompts for valid duration format |
| AF-001c | HRM connection unavailable | System displays warning; Allow save as draft |
| AF-001d | Required fields missing | System highlights missing fields; Block submission |

### Post-conditions (Success)
- Course record created in database
- Course appears in course catalog
- Audit log entry created

### Post-conditions (Failure)
- No record created
- User receives error message with details

---

## 2. Enroll Employee in Course

### Use Case: UC-002 - Enroll Employee in Course

| Field | Value |
|-------|-------|
| **Actor** | Training Administrator, Employee (Self-enrollment) |
| **Description** | Enroll an employee in a specific training course manually or via self-service |
| **Pre-conditions** | Course exists; Employee exists in ksf_HRM; Course has available capacity |
| **Post-conditions** | Enrollment record created; Employee notified of enrollment |

### Main Flow

| Step | Actor | Action |
|------|-------|--------|
| 1 | Actor | Search for course by name or category |
| 2 | System | Display available course sessions |
| 3 | Actor | Select course session |
| 4 | System | Retrieve employee data from ksf_HRM |
| 5 | System | Validate employee eligibility (prerequisites, capacity) |
| 6 | Actor | Confirm enrollment |
| 7 | System | Create enrollment record with status "Enrolled" |
| 8 | System | Send enrollment notification to employee |
| 9 | System | Update course capacity count |

### Alternative Flows

| ID | Condition | Action |
|----|-----------|--------|
| AF-002a | Course full | System displays "Course Full"; Offer waitlist option |
| AF-002b | Prerequisites not met | System displays missing prerequisites; Block enrollment |
| AF-002c | Employee already enrolled | System displays existing enrollment; Allow status check |
| AF-002d | Past enrollment exists | System offers "Re-enroll" or "View Certificate" |
| AF-002e | Manager approval required | System routes to manager for approval |
| AF-002f | Self-enrollment disabled | System requires administrator enrollment |

### Post-conditions (Success)
- Enrollment record created with timestamp
- Notification sent to employee
- Calendar event created (if scheduled)

### Post-conditions (Failure)
- No enrollment created
- Appropriate error displayed

---

## 3. Track Course Completion

### Use Case: UC-003 - Track Course Completion

| Field | Value |
|-------|-------|
| **Actor** | Training Administrator, System (Automated) |
| **Description** | Record and track employee progress and completion status for enrolled courses |
| **Pre-conditions** | Employee is enrolled in course; Course has defined modules/topics |
| **Post-conditions** | Completion status updated; Progress percentage calculated |

### Main Flow

| Step | Actor | Action |
|------|-------|--------|
| 1 | System | Display enrolled employees for course |
| 2 | Training Administrator | Select employee to track |
| 3 | System | Display course modules and completion status |
| 4 | Training Administrator | Mark completed modules as complete |
| 5 | System | Calculate overall progress percentage |
| 6 | System | Update completion status (In Progress, Completed) |
| 7 | System | Record completion date |
| 8 | System | Trigger certification workflow if 100% complete |

### Alternative Flows

| ID | Condition | Action |
|----|-----------|--------|
| AF-003a | Online course completion | System auto-imports completion data from LMS |
| AF-003b | Partial completion | System maintains progress; Employee can resume |
| AF-003c | Assessment not passed | System records attempt; Allow retake per policy |
| AF-003d | Course过期 | System marks as "Expired" or "Requires Recertification" |
| AF-003e | External training credit | Administrator manually enters completion record |

### Post-conditions (Success)
- Completion percentage updated
- Status changed to "Completed" when 100%
- Completion record added to training history

### Post-conditions (Failure)
- Status remains "In Progress"
- Error logged

---

## 4. Issue Certification

### Use Case: UC-004 - Issue Certification

| Field | Value |
|-------|-------|
| **Actor** | System (Automated), Training Administrator (Manual) |
| **Description** | Generate and issue certification upon successful course completion |
| **Pre-conditions** | Course completion verified; Course has certification enabled; All requirements met |
| **Post-conditions** | Certification record created; Certificate generated; Employee notified |

### Main Flow

| Step | Actor | Action |
|------|-------|--------|
| 1 | System | Detect course completion |
| 2 | System | Verify all certification requirements met |
| 3 | System | Generate unique Certification ID |
| 4 | System | Create certification record with expiry date |
| 5 | System | Generate certificate document (PDF) |
| 6 | System | Store certificate in document management |
| 7 | System | Notify employee of certification |
| 8 | System | Update employee training history in ksf_HRM |
| 9 | System | Log certification issuance |

### Alternative Flows

| ID | Condition | Action |
|----|-----------|--------|
| AF-004a | Manual certification | Administrator initiates certification process |
| AF-004b | Digital certificate | System sends via email with verification link |
| AF-004c | Physical certificate | System queues for printing and mailing |
| AF-004d | Recertification required | System flags for renewal; Send reminder |
| AF-004e | Certificate revoked | Administrator revokes; System updates status |
| AF-004f | External certification | Administrator imports external certificate data |

### Post-conditions (Success)
- Certification record created
- Certificate document generated
- ksf_HRM updated with certification data

### Post-conditions (Failure)
- Certification pending review
- Administrator notified of issue

---

## 5. Track Compliance Status

### Use Case: UC-005 - Track Compliance Status

| Field | Value |
|-------|-------|
| **Actor** | Training Administrator, HR Manager, Compliance Officer |
| **Description** | Monitor and report on employee compliance with mandatory training requirements |
| **Pre-conditions** | Mandatory training requirements defined; Employee data available from ksf_HRM |
| **Post-conditions** | Compliance status calculated; Reports generated |

### Main Flow

| Step | Actor | Action |
|------|-------|--------|
| 1 | Actor | Access Compliance Dashboard |
| 2 | System | Retrieve mandatory requirements by department/role |
| 3 | System | Retrieve employee training records from ksf_HRM |
| 4 | System | Calculate compliance status per employee |
| 5 | System | Display compliance matrix (Employee x Requirement) |
| 6 | Actor | Filter by department, status, or deadline |
| 7 | System | Highlight non-compliant employees |
| 8 | Actor | Generate compliance report |
| 9 | System | Export report (PDF, Excel) |

### Alternative Flows

| ID | Condition | Action |
|----|-----------|--------|
| AF-005a | Overdue training | System flags employee; Send reminder notification |
| AF-005b | Expiring certification | System sends renewal reminder (30, 14, 7 days) |
| AF-005c | Department-level view | System aggregates by department |
| AF-005d | Compliance exception | Administrator grants temporary waiver |
| AF-005e | Real-time sync | System syncs with ksf_HRM for latest data |

### Post-conditions (Success)
- Compliance dashboard updated
- Reports available for download
- Notifications sent for non-compliant employees

### Post-conditions (Failure)
- Sync error logged
- Manual refresh option available

---

## 6. Schedule Training Event

### Use Case: UC-006 - Schedule Training Event

| Field | Value |
|-------|-------|
| **Actor** | Training Administrator |
| **Description** | Schedule a training course session with date, time, location, and resources |
| **Pre-conditions** | Course exists; ksf_Calendar connection available |
| **Post-conditions** | Training event created in ksf_Calendar; Enrolled employees notified |

### Main Flow

| Step | Actor | Action |
|------|-------|--------|
| 1 | Training Administrator | Select course to schedule |
| 2 | Training Administrator | Choose scheduling method (single session, recurring) |
| 3 | Training Administrator | Set date and time |
| 4 | Training Administrator | Specify location (physical, virtual, hybrid) |
| 5 | Training Administrator | Add virtual meeting details (if applicable) |
| 6 | Training Administrator | Assign instructor(s) |
| 7 | Training Administrator | Configure capacity and waitlist settings |
| 8 | Training Administrator | Save schedule |
| 9 | System | Create event in ksf_Calendar |
| 10 | System | Send calendar invites to enrolled employees |
| 11 | System | Update course session status |

### Alternative Flows

| ID | Condition | Action |
|----|-----------|--------|
| AF-006a | Instructor conflict | System detects conflict; Prompt for alternative |
| AF-006b | Room unavailable | System shows available rooms; Allow booking |
| AF-006c | Recurring schedule | System generates all sessions automatically |
| AF-006d | Reschedule | System cancels old event; Creates new; Notifies attendees |
| AF-006e | Cancel event | System cancels; Notifies all enrolled; Offers refund/transfer |
| AF-006f | Calendar sync failure | System retries; Logs error; Admin notified |

### Post-conditions (Success)
- Event created in ksf_Calendar
- Enrolled employees receive invitations
- Event visible in course schedule

### Post-conditions (Failure)
- Event saved as "Pending Calendar Sync"
- Manual calendar creation option available

---

## 7. View Training History

### Use Case: UC-007 - View Training History

| Field | Value |
|-------|-------|
| **Actor** | Employee, HR Manager, Training Administrator |
| **Description** | View complete training history including courses, certifications, and compliance status |
| **Pre-conditions** | User authenticated; Employee data available from ksf_HRM |
| **Post-conditions** | Training history displayed with filters and export options |

### Main Flow

| Step | Actor | Action |
|------|-------|--------|
| 1 | Actor | Access Training History (via ksf_HRM or direct) |
| 2 | System | Authenticate user and verify permissions |
| 3 | System | Retrieve employee ID from ksf_HRM |
| 4 | System | Fetch all training records for employee |
| 5 | System | Fetch all certifications and expiry dates |
| 6 | System | Display training history chronologically |
| 7 | Actor | Apply filters (date range, course type, status) |
| 8 | Actor | View certificate details |
| 9 | Actor | Export training history (PDF, CSV) |

### Alternative Flows

| ID | Condition | Action |
|----|-----------|--------|
| AF-007a | Manager view | HR Manager views team member history (with permission) |
| AF-007b | External verification | Third party verifies certification via QR code/link |
| AF-007c | Self-service download | Employee downloads own certificates |
| AF-007d | Incomplete data | System displays "Data sync in progress" |
| AF-007e | Cross-module data | System fetches related data from ksf_Performance |

### Post-conditions (Success)
- Training history displayed
- Filters applied and persisted
- Export generated

### Post-conditions (Failure)
- Access denied message displayed
- Sync error notification

---

## 8. Add Training to Performance Review

### Use Case: UC-008 - Add Training to Performance Review

| Field | Value |
|-------|-------|
| **Actor** | Employee, Line Manager, HR Manager |
| **Description** | Associate completed training with performance review for evaluation purposes |
| **Pre-conditions** | Training completed; ksf_Performance module accessible; Review period active |
| **Post-conditions** | Training linked to performance review; Available in ksf_Performance |

### Main Flow

| Step | Actor | Action |
|------|-------|--------|
| 1 | Actor | Initiate or access performance review |
| 2 | System | Display review form from ksf_Performance |
| 3 | Actor | Navigate to Training section |
| 4 | System | Display eligible training records (completed, current year) |
| 5 | Actor | Select training to add to review |
| 6 | System | Link training record to review |
| 7 | Actor | Add manager comments or rating on training |
| 8 | System | Save and sync with ksf_Performance |
| 9 | System | Confirm successful linkage |

### Alternative Flows

| ID | Condition | Action |
|----|-----------|--------|
| AF-008a | Training not linked | Employee requests link to completed training |
| AF-008b | Missing training data | System offers to sync from ksf_HRM |
| AF-008c | Review period closed | System blocks modification; Requires override |
| AF-008d | Certification credit | System applies training toward competency goal |
| AF-008e | Goal creation | System suggests training based on competency gap |

### Post-conditions (Success)
- Training linked to review
- Data synced to ksf_Performance
- Audit log updated

### Post-conditions (Failure)
- Link not created
- Error message with retry option

---

## 9. Set Mandatory Training Requirements

### Use Case: UC-009 - Set Mandatory Training Requirements

| Field | Value |
|-------|-------|
| **Actor** | HR Manager, Training Administrator, Compliance Officer |
| **Description** | Define mandatory training requirements by department, role, or regulatory compliance |
| **Pre-conditions** | Courses exist; Employee structure available from ksf_HRM |
| **Post-conditions** | Requirement created; Compliance tracking enabled |

### Main Flow

| Step | Actor | Action |
|------|-------|--------|
| 1 | Actor | Access Requirement Management |
| 2 | Actor | Select "Create Mandatory Requirement" |
| 3 | Actor | Choose requirement type (Regulatory, Company Policy, Role-based) |
| 4 | Actor | Select target (Department, Job Role, All Employees) |
| 5 | Actor | Select required course(s) |
| 6 | Actor | Set completion deadline (One-time, Annual, Recurring) |
| 7 | Actor | Configure renewal period |
| 8 | Actor | Set notification preferences (reminder days) |
| 9 | Actor | Save requirement |
| 10 | System | Create requirement record |
| 11 | System | Generate compliance assignments for affected employees |
| 12 | System | Send notifications to affected employees |

### Alternative Flows

| ID | Condition | Action |
|----|-----------|--------|
| AF-009a | Regulatory requirement | System captures regulatory reference code |
| AF-009b | Global requirement | System applies to all employees automatically |
| AF-009c | New employee | System applies requirements on hire date |
| AF-009d | Role change | System reassigns requirements when role changes |
| AF-009e | Requirement conflict | System warns if overlapping requirements |
| AF-009f | Bulk import | Administrator imports requirements from spreadsheet |

### Post-conditions (Success)
- Requirement record created
- Affected employees notified
- Compliance tracking enabled

### Post-conditions (Failure)
- Requirement saved as draft
- Validation errors displayed

---

## Cross-Cutting Concerns

### Error Handling
- All use cases implement retry logic for transient failures
- Failed operations are logged with full context
- User-friendly error messages displayed

### Security
- Role-based access control enforced
- Audit logging for all data changes
- Data encryption for PII

### Notifications
- Email notifications for enrollment, completion, certification
- Calendar integration via ksf_Calendar
- Reminder system for deadlines and expiring certifications

### Integration Points
| Module | Integration Type | Data Flow |
|--------|------------------|-----------|
| ksf_HRM | Consumer | Employee data, Department structure |
| ksf_HRM | Provider | Training history, Certifications |
| ksf_Calendar | Consumer | Training events |
| ksf_Calendar | Provider | Training schedule |
| ksf_Performance | Provider | Training linked to reviews |

---

*Document Version: 1.0.0*
