# Use Cases - ksf_Training

## UC-TR-001: Schedule Training
**Actor**: HR Manager

**Flow**:
1. Navigate to Training > New Course
2. Enter course details
3. Set schedule (ksf_Calendar)
4. Assign employees
5. Send notifications

## UC-TR-002: Complete Training
**Actor**: Employee

**Flow**:
1. Employee attends/completes training
2. Mark as complete
3. System updates:
   - ksf_HRM training history
   - Certification record (if applicable)
4. If certification expiring → reminder set

## UC-TR-003: Compliance Training Tracking
**Actor**: HR Manager, System

**Flow**:
1. Assign required training to employees
2. System tracks completion
3. Non-compliance alerts
4. Reports for compliance audits

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*