<?php

declare(strict_types=1);

namespace DevRecord\Domain\Category;

use DevRecord\Domain\Common\Id;

final class Category
{
    public function __construct(
        private Id $id,
        private CategoryInfo $info,
    ) {
    }

    public static function createNew(string $name, string $slug): self
    {
        $info = new CategoryInfo($name, $slug);

        return (new Category(Id::issueNew(), $info));
    }

    public static function create(string $id, string $name, string $slug): self
    {
        $info = new CategoryInfo($name, $slug);

        return (new Category((new Id($id)), $info));
    }

    public function update(CategoryInfo $info): self
    {
        return new Category($this->id, $info);
    }

    public function toDto(): CategoryDto
    {
        return (new CategoryDto($this->id->toDto(), $this->info->toDto()));
    }

    public function toJson(): array
    {
        return array_merge($this->id->toJson(), $this->info->toJson());
    }

    public function isSame(Id $id): bool
    {
        return $this->id->equal($id);
    }
}
