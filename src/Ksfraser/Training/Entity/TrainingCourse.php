<?php

declare(strict_types=1);

namespace Ksfraser\Training\Entity;

class TrainingCourse
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_ARCHIVED = 'archived';

    private ?int $id = null;
    private string $title = '';
    private string $description = '';
    private string $category = 'General';
    private string $duration = '';
    private string $instructor = '';
    private string $status = self::STATUS_DRAFT;
    private ?int $createdBy = null;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->category = $data['category'] ?? 'General';
        $this->duration = $data['duration'] ?? '';
        $this->instructor = $data['instructor'] ?? '';
        $this->status = $data['status'] ?? self::STATUS_DRAFT;
        $this->createdBy = $data['created_by'] ?? null;
        $this->createdAt = new \DateTime($data['created_at'] ?? 'now');
        $this->updatedAt = new \DateTime($data['updated_at'] ?? 'now');
    }

    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function getCategory(): string { return $this->category; }
    public function setCategory(string $category): self { $this->category = $category; return $this; }
    public function getDuration(): string { return $this->duration; }
    public function setDuration(string $duration): self { $this->duration = $duration; return $this; }
    public function getInstructor(): string { return $this->instructor; }
    public function setInstructor(string $instructor): self { $this->instructor = $instructor; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function getCreatedBy(): ?int { return $this->createdBy; }
    public function setCreatedBy(?int $createdBy): self { $this->createdBy = $createdBy; return $this; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }
    public function getUpdatedAt(): \DateTime { return $this->updatedAt; }
    public function isPublished(): bool { return $this->status === self::STATUS_PUBLISHED; }
}