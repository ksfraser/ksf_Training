<?php

declare(strict_types=1);

namespace Ksfraser\Training\Service;

use Ksfraser\Training\Entity\TrainingCourse;
use Ksfraser\Training\Entity\Enrollment;

class TrainingService
{
    private array $courses = [];
    private array $enrollments = [];

    public function createCourse(array $data): TrainingCourse
    {
        $course = new TrainingCourse($data);
        $this->courses[$course->getId() ?? count($this->courses) + 1] = $course;
        return $course;
    }

    public function getCourse(int $id): ?TrainingCourse
    {
        return $this->courses[$id] ?? null;
    }

    public function getPublishedCourses(): array
    {
        $published = [];
        foreach ($this->courses as $course) {
            if ($course->isPublished()) {
                $published[] = $course;
            }
        }
        return $published;
    }

    public function enrollEmployee(int $courseId, int $employeeId): Enrollment
    {
        $enrollment = new Enrollment();
        $enrollment->setCourseId($courseId);
        $enrollment->setEmployeeId($employeeId);
        $enrollment->setStatus(Enrollment::STATUS_ENROLLED);
        $enrollment->setEnrolledAt(date('Y-m-d H:i:s'));
        $enrollment->setProgress(0);

        $id = $enrollment->getId() ?? count($this->enrollments) + 1;
        $enrollment->setId($id);
        $this->enrollments[$id] = $enrollment;
        return $enrollment;
    }

    public function getEnrollment(int $id): ?Enrollment
    {
        return $this->enrollments[$id] ?? null;
    }

    public function startCourse(int $enrollmentId): ?Enrollment
    {
        $enrollment = $this->getEnrollment($enrollmentId);
        if ($enrollment === null) return null;

        $enrollment->setStatus(Enrollment::STATUS_IN_PROGRESS);
        $enrollment->setStartedAt(date('Y-m-d H:i:s'));
        return $enrollment;
    }

    public function completeCourse(int $enrollmentId): ?Enrollment
    {
        $enrollment = $this->getEnrollment($enrollmentId);
        if ($enrollment === null) return null;

        $enrollment->setStatus(Enrollment::STATUS_COMPLETED);
        $enrollment->setCompletedAt(date('Y-m-d H:i:s'));
        $enrollment->setProgress(100);
        return $enrollment;
    }

    public function updateProgress(int $enrollmentId, float $progress): ?Enrollment
    {
        $enrollment = $this->getEnrollment($enrollmentId);
        if ($enrollment === null) return null;

        $enrollment->setProgress($progress);
        return $enrollment;
    }

    public function getEmployeeEnrollments(int $employeeId): array
    {
        $enrollments = [];
        foreach ($this->enrollments as $enrollment) {
            if ($enrollment->getEmployeeId() === $employeeId) {
                $enrollments[] = $enrollment;
            }
        }
        return $enrollments;
    }
}