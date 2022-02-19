<?php

namespace DevRecord\Domain\Category;

final class CategoryInfoDto
{
    public function __construct(
        private string $name,
        private string $slug,
    )
    {
    }

    public function toColumns(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
