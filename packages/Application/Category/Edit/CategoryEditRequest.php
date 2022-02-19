<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Edit;

use DevRecord\Domain\Category\CategoryInfo;
use DevRecord\Domain\Common\Id;

final class CategoryEditRequest
{
    public function __construct(
        private string $id,
        private string $name,
        private string $slug,
    ) {
    }

    public function toId(): Id
    {
        return new Id($this->id);
    }

    public function toCategoryInfo(): CategoryInfo
    {
        return new CategoryInfo($this->name, $this->slug);
    }
}
