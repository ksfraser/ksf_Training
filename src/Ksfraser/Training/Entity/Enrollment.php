<?php

declare(strict_types=1);

namespace Ksfraser\Training\Entity;

class Enrollment
{
    public const STATUS_ENROLLED = 'enrolled';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    private ?int $id = null;
    private int $courseId = 0;
    private int $employeeId = 0;
    private string $status = self::STATUS_ENROLLED;
    private ?string $enrolledAt = null;
    private ?string $startedAt = null;
    private ?string $completedAt = null;
    private ?string $certificateUrl = null;
    private float $progress = 0;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getCourseId(): int { return $this->courseId; }
    public function setCourseId(int $courseId): self { $this->courseId = $courseId; return $this; }
    public function getEmployeeId(): int { return $this->employeeId; }
    public function setEmployeeId(int $employeeId): self { $this->employeeId = $employeeId; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function getEnrolledAt(): ?string { return $this->enrolledAt; }
    public function setEnrolledAt(?string $enrolledAt): self { $this->enrolledAt = $enrolledAt; return $this; }
    public function getStartedAt(): ?string { return $this->startedAt; }
    public function setStartedAt(?string $startedAt): self { $this->startedAt = $startedAt; return $this; }
    public function getCompletedAt(): ?string { return $this->completedAt; }
    public function setCompletedAt(?string $completedAt): self { $this->completedAt = $completedAt; return $this; }
    public function getCertificateUrl(): ?string { return $this->certificateUrl; }
    public function setCertificateUrl(?string $certificateUrl): self { $this->certificateUrl = $certificateUrl; return $this; }
    public function getProgress(): float { return $this->progress; }
    public function setProgress(float $progress): self { $this->progress = $progress; return $this; }
    public function isCompleted(): bool { return $this->status === self::STATUS_COMPLETED; }
}