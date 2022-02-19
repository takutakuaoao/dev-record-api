<?php

declare(strict_types=1);

namespace DevRecord\Domain\Category;

final class CategoryInfo
{
    public function __construct(
        private string $name,
        private string $slug,
    ) {
    }

    public function toDto(): CategoryInfoDto
    {
        return new CategoryInfoDto($this->name, $this->slug);
    }

    public function toJson(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
