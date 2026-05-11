<?php

declare(strict_types=1);

namespace Ksfraser\Training\Entity;

class Course
{
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_INACTIVE = 'Inactive';
    public const STATUS_RETIRED = 'Retired';

    private ?int $id = null;
    private string $title = '';
    private string $description = '';
    private string $category = '';
    private int $durationHours = 0;
    private string $status = self::STATUS_ACTIVE;
    private ?int $providerId = null;
    private bool $mandatory = false;
    private bool $certificationRequired = false;
    private ?string $certificationExpiry = null;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function getCategory(): string { return $this->category; }
    public function setCategory(string $category): self { $this->category = $category; return $this; }
    public function getDurationHours(): int { return $this->durationHours; }
    public function setDurationHours(int $durationHours): self { $this->durationHours = $durationHours; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function getProviderId(): ?int { return $this->providerId; }
    public function setProviderId(?int $providerId): self { $this->providerId = $providerId; return $this; }
    public function isMandatory(): bool { return $this->mandatory; }
    public function setMandatory(bool $mandatory): self { $this->mandatory = $mandatory; return $this; }
    public function isCertificationRequired(): bool { return $this->certificationRequired; }
    public function setCertificationRequired(bool $certificationRequired): self { $this->certificationRequired = $certificationRequired; return $this; }
    public function getCertificationExpiry(): ?string { return $this->certificationExpiry; }
    public function setCertificationExpiry(?string $certificationExpiry): self { $this->certificationExpiry = $certificationExpiry; return $this; }
    public function isActive(): bool { return $this->status === self::STATUS_ACTIVE; }
}

class TrainingEnrollment
{
    public const STATUS_ENROLLED = 'Enrolled';
    public const STATUS_IN_PROGRESS = 'In Progress';
    public const STATUS_COMPLETED = 'Completed';
    public const STATUS_FAILED = 'Failed';
    public const STATUS_EXPIRED = 'Expired';

    private ?int $id = null;
    private int $employeeId = 0;
    private int $courseId = 0;
    private string $status = self::STATUS_ENROLLED;
    private ?string $enrolledDate = null;
    private ?string $completedDate = null;
    private ?string $expiryDate = null;
    private ?int $score = null;
    private bool $passed = false;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getEmployeeId(): int { return $this->employeeId; }
    public function setEmployeeId(int $employeeId): self { $this->employeeId = $employeeId; return $this; }
    public function getCourseId(): int { return $this->courseId; }
    public function setCourseId(int $courseId): self { $this->courseId = $courseId; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function getEnrolledDate(): ?string { return $this->enrolledDate; }
    public function setEnrolledDate(?string $enrolledDate): self { $this->enrolledDate = $enrolledDate; return $this; }
    public function getCompletedDate(): ?string { return $this->completedDate; }
    public function setCompletedDate(?string $completedDate): self { $this->completedDate = $completedDate; return $this; }
    public function getExpiryDate(): ?string { return $this->expiryDate; }
    public function setExpiryDate(?string $expiryDate): self { $this->expiryDate = $expiryDate; return $this; }
    public function getScore(): ?int { return $this->score; }
    public function setScore(?int $score): self { $this->score = $score; return $this; }
    public function hasPassed(): bool { return $this->passed; }
    public function setPassed(bool $passed): self { $this->passed = $passed; return $this; }
    public function isCompleted(): bool { return $this->status === self::STATUS_COMPLETED; }
    public function isExpired(): bool { return $this->status === self::STATUS_EXPIRED; }
}