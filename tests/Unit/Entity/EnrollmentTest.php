<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\Training\Entity;

use Ksfraser\Training\Entity\Enrollment;
use PHPUnit\Framework\TestCase;

class EnrollmentTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $enrollment = new Enrollment();

        $this->assertNull($enrollment->getId());
        $this->assertSame(0, $enrollment->getCourseId());
        $this->assertSame(0, $enrollment->getEmployeeId());
        $this->assertSame('enrolled', $enrollment->getStatus());
        $this->assertFalse($enrollment->isCompleted());
    }

    /**
     * @covers Ksfraser\Training\Entity\Enrollment::setId
     */
    public function testSetId(): void
    {
        $enrollment = new Enrollment();
        $result = $enrollment->setId(1);

        $this->assertInstanceOf(Enrollment::class, $result);
        $this->assertSame(1, $enrollment->getId());
    }

    /**
     * @covers Ksfraser\Training\Entity\Enrollment::setProgress
     */
    public function testSetProgress(): void
    {
        $enrollment = new Enrollment();
        $result = $enrollment->setProgress(75.0);

        $this->assertInstanceOf(Enrollment::class, $result);
        $this->assertSame(75.0, $enrollment->getProgress());
    }

    /**
     * @covers Ksfraser\Training\Entity\Enrollment::isCompleted
     */
    public function testIsCompleted(): void
    {
        $enrollment = new Enrollment();
        $enrollment->setStatus('in_progress');
        $this->assertFalse($enrollment->isCompleted());

        $enrollment->setStatus('completed');
        $this->assertTrue($enrollment->isCompleted());
    }
}