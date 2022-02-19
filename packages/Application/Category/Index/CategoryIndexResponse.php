<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Index;

final class CategoryIndexResponse
{
    public function __construct(
        private array $categories,
    ) {
    }

    public function toArray(): array
    {
        return [
            'items' => $this->categories,
        ];
    }
}
