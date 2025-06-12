<?php

namespace src\models\dto;

class TreeNodeDTO
{
    private int $id;

    private ?int $parentId;

    private ?string $title;

    private array $childList;

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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getChildList(): array
    {
        return $this->childList ?? [];
    }

    public function addChild(TreeNodeDTO $child): void
    {
        $this->childList[] = $child;
    }
}