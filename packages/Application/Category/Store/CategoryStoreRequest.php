<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Store;

use DevRecord\Domain\Category\Category;

final class CategoryStoreRequest
{
    public function __construct(
        private string $name,
        private string $slug,
    ) {
    }

    public function makeCategory(): Category
    {
        return Category::createNew($this->name, $this->slug);
    }
}
