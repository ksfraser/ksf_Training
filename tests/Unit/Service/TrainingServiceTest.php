<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\Training\Service;

use Ksfraser\Training\Entity\TrainingCourse;
use Ksfraser\Training\Entity\Enrollment;
use Ksfraser\Training\Service\TrainingService;
use PHPUnit\Framework\TestCase;

class TrainingServiceTest extends TestCase
{
    private TrainingService $service;

    protected function setUp(): void
    {
        $this->service = new TrainingService();
    }

    /**
     * @covers Ksfraser\Training\Service\TrainingService::createCourse
     */
    public function testCreateCourse(): void
    {
        $course = $this->service->createCourse([
            'id' => 1,
            'title' => 'Safety Training',
            'category' => 'Compliance',
            'status' => 'published',
        ]);

        $this->assertInstanceOf(TrainingCourse::class, $course);
        $this->assertSame('Safety Training', $course->getTitle());
    }

    /**
     * @covers Ksfraser\Training\Service\TrainingService::enrollEmployee
     */
    public function testEnrollEmployee(): void
    {
        $enrollment = $this->service->enrollEmployee(10, 100);

        $this->assertInstanceOf(Enrollment::class, $enrollment);
        $this->assertSame(10, $enrollment->getCourseId());
        $this->assertSame(100, $enrollment->getEmployeeId());
        $this->assertSame('enrolled', $enrollment->getStatus());
    }

    /**
     * @covers Ksfraser\Training\Service\TrainingService::startCourse
     */
    public function testStartCourse(): void
    {
        $enrollment = $this->service->enrollEmployee(1, 1);

        $started = $this->service->startCourse($enrollment->getId());

        $this->assertNotNull($started);
        $this->assertSame('in_progress', $started->getStatus());
    }

    /**
     * @covers Ksfraser\Training\Service\TrainingService::completeCourse
     */
    public function testCompleteCourse(): void
    {
        $enrollment = $this->service->enrollEmployee(1, 1);

        $completed = $this->service->completeCourse($enrollment->getId());

        $this->assertNotNull($completed);
        $this->assertSame('completed', $completed->getStatus());
        $this->assertSame(100.0, $completed->getProgress());
    }

    /**
     * @covers Ksfraser\Training\Service\TrainingService::updateProgress
     */
    public function testUpdateProgress(): void
    {
        $enrollment = $this->service->enrollEmployee(1, 1);

        $updated = $this->service->updateProgress($enrollment->getId(), 50.0);

        $this->assertNotNull($updated);
        $this->assertSame(50.0, $updated->getProgress());
    }
}