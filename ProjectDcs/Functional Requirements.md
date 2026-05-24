# Functional Requirements - ksf_Training

## Document Information
- **Module**: ksf_Training
- **Version**: 1.0.0
- **Date**: 2026-05-24
- **Status**: Draft
- **Author**: KSFII Development Team

---

## 1. Course Management

### FR-TRN-001: Create Course
**Description**: Training Admin can create courses in the catalog.

| Field | Type | Required | Notes |
|-------|------|----------|-------|
| name | string | Yes | Course name |
| description | text | No | Course description |
| type | enum | Yes | online, classroom, workshop, seminar |
| duration_hours | integer | Yes | Length in hours |
| is_mandatory | boolean | Yes | Compliance-required flag |
| department_id | string | No | Target department |

### FR-TRN-002: Course Maintenance
**Description**: Training Admin can update course details and set status to active, inactive, or archived. Inactive courses cannot have new sessions scheduled.

---

## 2. Session Scheduling

### FR-TRN-003: Create Training Session
**Description**: Training Admin can schedule sessions for a course with dates, instructor, and max attendees.

| Field | Type | Required | Notes |
|-------|------|----------|-------|
| course_id | string | Yes | FK to course |
| start_date | datetime | Yes | Session start |
| end_date | datetime | Yes | Session end |
| max_attendees | integer | Yes | Capacity |
| instructor_id | string | No | FK to crm_persons |

### FR-TRN-004: Session Management
**Description**: Sessions can transition through statuses: scheduled → in_progress → completed → cancelled. Cancelled sessions notify all enrolled employees.

---

## 3. Enrollment and Tracking

### FR-TRN-005: Enroll Employee
**Description**: Employees can self-enroll in available sessions (non-mandatory courses). Training Admin and Managers can enroll employees in any session.

### FR-TRN-006: Enrollment Status
**Description**: Enrollments flow through: enrolled → in_progress → completed. Failed completions: cancelled (by admin) or no_show (automatic after session end without attendance).

| Field | Type | Required | Notes |
|-------|------|----------|-------|
| employee_id | string | Yes | FK to crm_persons |
| session_id | string | Yes | FK to training_session |
| status | enum | Yes | enrollment lifecycle |
| score | integer | No | Test score if applicable |
| passed | boolean | No | Pass/fail status |

---

## 4. Certification Integration

### FR-TRN-007: Certificate Issuance
**Description**: Upon successful completion (passed=true), a certificate ID is generated and recorded. Certificates are linked to the employee record for profile display.

### FR-TRN-008: Certification Expiry
**Description**: Courses can be configured with a certification expiry period. The system flags expiring certifications 30 days before expiry and triggers re-enrollment workflows.

---

## 5. Compliance Reporting

### FR-TRN-009: Compliance Dashboard
**Description**: HR and Training Admin can view mandatory course completion rates by department, role, and individual.

### FR-TRN-010: Compliance Alerts
**Description**: Automatic notifications for:
- Overdue mandatory enrollments (passed due date)
- Non-compliant employees (not completed within required timeframe)
- Expiring certifications

---

## 6. RBAC Integration

### FR-TRN-011: Role-Based Access
**Description**: Access to courses, sessions, and enrollments is controlled via ksfraser/rbac:

| Role | Access Level | Scope |
|------|-------------|-------|
| Training Admin | FULL | All courses, sessions, enrollments |
| Manager | PUBLIC + approval | Direct reports' enrollments |
| Employee | FULL (own) + PUBLIC (catalog) | Self-enroll, view own records |
| HR | PUBLIC + reports | Compliance data |
| Instructor | FULL | Assigned sessions |

### FR-TRN-012: Data Projections
**Description**: The module enforces PUBLIC vs FULL projections per the RBAC entity projection table defined in Architecture.md §3.2. Test scores and certificate IDs are FULL-only.

### FR-TRN-013: Record Visibility
**Description**: Enrollments are visible via the standard RBAC JOIN pattern. Employee self-enrollment queries use the individual team for FULL projection on own records.

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-24*
