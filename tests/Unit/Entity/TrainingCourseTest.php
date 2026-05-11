<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\Training\Entity;

use Ksfraser\Training\Entity\TrainingCourse;
use PHPUnit\Framework\TestCase;

class TrainingCourseTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $course = new TrainingCourse();

        $this->assertNull($course->getId());
        $this->assertSame('', $course->getTitle());
        $this->assertSame('draft', $course->getStatus());
        $this->assertNull($course->getCreatedBy());
    }

    /**
     * @covers Ksfraser\Training\Entity\TrainingCourse::__construct
     */
    public function testConstructWithData(): void
    {
        $course = new TrainingCourse([
            'id' => 1,
            'title' => 'Safety Training',
            'category' => 'Compliance',
            'status' => 'published',
        ]);

        $this->assertSame(1, $course->getId());
        $this->assertSame('Safety Training', $course->getTitle());
        $this->assertSame('Compliance', $course->getCategory());
    }

    /**
     * @covers Ksfraser\Training\Entity\TrainingCourse::isPublished
     */
    public function testIsPublished(): void
    {
        $course = new TrainingCourse(['status' => 'published']);
        $this->assertTrue($course->isPublished());

        $course->setStatus('draft');
        $this->assertFalse($course->isPublished());
    }
}