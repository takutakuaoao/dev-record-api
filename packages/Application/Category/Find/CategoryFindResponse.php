<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Find;

final class CategoryFindResponse
{
    public function __construct(
        private array $category,
    ) {
    }

    public function toArray(): array
    {
        return [
            'item' => $this->category,
        ];
    }
}
