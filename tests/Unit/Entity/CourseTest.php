<?php

declare(strict_types=1);

namespace Ksfraser\Training\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Ksfraser\Training\Entity\Course;
use Ksfraser\Training\Entity\TrainingEnrollment;

class CourseTest extends TestCase
{
    public function testCanCreateCourse(): void
    {
        $course = new Course();
        $this->assertInstanceOf(Course::class, $course);
    }

    public function testCanSetAndGetTitle(): void
    {
        $course = new Course();
        $course->setTitle('Safety Training');
        $this->assertEquals('Safety Training', $course->getTitle());
    }

    public function testCanCheckIsActive(): void
    {
        $course = new Course();
        $course->setStatus(Course::STATUS_ACTIVE);
        $this->assertTrue($course->isActive());
    }
}

class TrainingEnrollmentTest extends TestCase
{
    public function testCanCreateEnrollment(): void
    {
        $enrollment = new TrainingEnrollment();
        $this->assertInstanceOf(TrainingEnrollment::class, $enrollment);
    }

    public function testCanSetAndGetStatus(): void
    {
        $enrollment = new TrainingEnrollment();
        $enrollment->setStatus(TrainingEnrollment::STATUS_COMPLETED);
        $this->assertTrue($enrollment->isCompleted());
    }
}