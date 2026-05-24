# Architecture - ksf_Training

## Document Information
- **Module**: ksf_Training
- **Version**: 1.0.0
- **Date**: 2026-05-24
- **Status**: Draft
- **Author**: KSFII Development Team

---

## 1. Module Overview

ksf_Training manages employee training programs, course catalogs, enrollment tracking, certification management, and compliance reporting.

### 1.1 Namespace
```php
Ksfraser\Training\
```

### 1.2 Layer Pattern
```
ksf_Training/                → Business Logic
    ├── Entity/              → Domain entities
    ├── Service/             → Business services
    ├── Repository/          → Data access interfaces
    └── Exception/           → Domain exceptions
```

---

## 2. Core Entities

### 2.1 Course
```php
class Course {
    private string $id;
    private string $name;
    private string $description;
    private CourseType $type;            // online, classroom, workshop, seminar
    private int $durationHours;
    private bool $isMandatory;
    private ?string $departmentId;
    private CourseStatus $status;        // active, inactive, archived
}
```

### 2.2 TrainingSession
```php
class TrainingSession {
    private string $id;
    private string $courseId;
    private \DateTime $startDate;
    private \DateTime $endDate;
    private int $maxAttendees;
    private ?string $instructorId;
    private SessionStatus $status;       // scheduled, in_progress, completed, cancelled
}
```

### 2.3 Enrollment
```php
class Enrollment {
    private string $id;
    private string $sessionId;
    private string $employeeId;
    private EnrollmentStatus $status;    // enrolled, in_progress, completed, cancelled, no_show
    private ?\DateTime $completedAt;
    private ?bool $passed;
    private ?int $score;
    private ?string $certificateId;
}
```

---

## 3. RBAC Integration (ksfraser/rbac)

### 3.1 Module Registration

ksf_Training registers with ksfraser/rbac:
- record_types: 'course', 'training_session', 'enrollment'
- projections: 'public' (course name/type/duration, session dates, enrollment status), 'full' (all fields including cost, instructor data, test scores, certificate IDs)
- allow_invite: false
- children: training_session (child of course), enrollment (child of training_session)

### 3.2 Entity Projections

| Entity | PUBLIC Fields | FULL Fields |
|--------|---------------|-------------|
| Course | name, description, type, duration, is_mandatory | + cost_per_head, department_id, vendor_id, contract_id, material_path |
| TrainingSession | course_id, dates, max_attendees, status | + instructor_id, room_id, cost, attendance_list, satisfaction_scores |
| Enrollment | employee_id, status, completed_at, passed | + score, certificate_id, cost_center, manager_approval_notes |

### 3.3 Access Model

- **Training Admin**: FULL to all courses, sessions, enrollments — PROJECTION_FULL
- **Manager**: View team enrollment status (PROJECTION_PUBLIC), approve/reject enrollment
- **Employee**: View own enrollments (PROJECTION_FULL for own via individual team), browse course catalog (PUBLIC)
- **HR**: View compliance training completion (PROJECTION_PUBLIC), generate reports
- **Instructor**: View assigned sessions (PROJECTION_FULL), record attendance/scores

### 3.4 SQL Enforcement

Standard RBAC JOIN pattern.

### 3.5 Soft Delete

- Courses are archived (inactive status), not hard-deleted
- Sessions may be cancelled (status change, not deleted)
- Enrollments preserve history (status = cancelled/no_show)

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-24*
