<?php

namespace src\models\entities;

class TreeNode
{
    private int $id;

    private ?int $parentId;

    private ?string $title;

    public function __construct(int $id, ?int $parentId = 0, ?string $title = '')
    {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->title = $title;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setParentId(?int $parentId): void
    {
        $this->parentId = $parentId;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parentId,
            'title' => $this->title,
        ];
    }
}
